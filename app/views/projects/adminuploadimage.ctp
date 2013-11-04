<!--script>
/*!
 * jQuery Validation Plugin 1.11.1
 *
 * http://bassistance.de/jquery-plugins/jquery-plugin-validation/
 * http://docs.jquery.com/Plugins/Validation
 *
 * Copyright 2013 Jörn Zaefferer
 * Released under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 */

(function($) {

    $.extend($.fn, {
        // http://docs.jquery.com/Plugins/Validation/validate
        validate: function( options ) {

            // if nothing is selected, return nothing; can't chain anyway
            if ( !this.length ) {
                if ( options && options.debug && window.console ) {
                    console.warn( "Nothing selected, can't validate, returning nothing." );
                }
                return;
            }

            // check if a validator for this form was already created
            var validator = $.data( this[0], "validator" );
            if ( validator ) {
                return validator;
            }

            // Add novalidate tag if HTML5.
            this.attr( "novalidate", "novalidate" );

            validator = new $.validator( options, this[0] );
            $.data( this[0], "validator", validator );

            if ( validator.settings.onsubmit ) {

                this.validateDelegate( ":submit", "click", function( event ) {
                    if ( validator.settings.submitHandler ) {
                        validator.submitButton = event.target;
                    }
                    // allow suppressing validation by adding a cancel class to the submit button
                    if ( $(event.target).hasClass("cancel") ) {
                        validator.cancelSubmit = true;
                    }

                    // allow suppressing validation by adding the html5 formnovalidate attribute to the submit button
                    if ( $(event.target).attr("formnovalidate") !== undefined ) {
                        validator.cancelSubmit = true;
                    }
                });

                // validate the form on submit
                this.submit( function( event ) {
                    if ( validator.settings.debug ) {
                        // prevent form submit to be able to see console output
                        event.preventDefault();
                    }
                    function handle() {
                        var hidden;
                        if ( validator.settings.submitHandler ) {
                            if ( validator.submitButton ) {
                                // insert a hidden input as a replacement for the missing submit button
                                hidden = $("<input type='hidden'/>").attr("name", validator.submitButton.name).val( $(validator.submitButton).val() ).appendTo(validator.currentForm);
                            }
                            validator.settings.submitHandler.call( validator, validator.currentForm, event );
                            if ( validator.submitButton ) {
                                // and clean up afterwards; thanks to no-block-scope, hidden can be referenced
                                hidden.remove();
                            }
                            return false;
                        }
                        return true;
                    }

                    // prevent submit for invalid forms or custom submit handlers
                    if ( validator.cancelSubmit ) {
                        validator.cancelSubmit = false;
                        return handle();
                    }
                    if ( validator.form() ) {
                        if ( validator.pendingRequest ) {
                            validator.formSubmitted = true;
                            return false;
                        }
                        return handle();
                    } else {
                        validator.focusInvalid();
                        return false;
                    }
                });
            }

            return validator;
        },
        // http://docs.jquery.com/Plugins/Validation/valid
        valid: function() {
            if ( $(this[0]).is("form")) {
                return this.validate().form();
            } else {
                var valid = true;
                var validator = $(this[0].form).validate();
                this.each(function() {
                    valid = valid && validator.element(this);
                });
                return valid;
            }
        },
        // attributes: space seperated list of attributes to retrieve and remove
        removeAttrs: function( attributes ) {
            var result = {},
                $element = this;
            $.each(attributes.split(/\s/), function( index, value ) {
                result[value] = $element.attr(value);
                $element.removeAttr(value);
            });
            return result;
        },
        // http://docs.jquery.com/Plugins/Validation/rules
        rules: function( command, argument ) {
            var element = this[0];

            if ( command ) {
                var settings = $.data(element.form, "validator").settings;
                var staticRules = settings.rules;
                var existingRules = $.validator.staticRules(element);
                switch(command) {
                    case "add":
                        $.extend(existingRules, $.validator.normalizeRule(argument));
                        // remove messages from rules, but allow them to be set separetely
                        delete existingRules.messages;
                        staticRules[element.name] = existingRules;
                        if ( argument.messages ) {
                            settings.messages[element.name] = $.extend( settings.messages[element.name], argument.messages );
                        }
                        break;
                    case "remove":
                        if ( !argument ) {
                            delete staticRules[element.name];
                            return existingRules;
                        }
                        var filtered = {};
                        $.each(argument.split(/\s/), function( index, method ) {
                            filtered[method] = existingRules[method];
                            delete existingRules[method];
                        });
                        return filtered;
                }
            }

            var data = $.validator.normalizeRules(
                $.extend(
                    {},
                    $.validator.classRules(element),
                    $.validator.attributeRules(element),
                    $.validator.dataRules(element),
                    $.validator.staticRules(element)
                ), element);

            // make sure required is at front
            if ( data.required ) {
                var param = data.required;
                delete data.required;
                data = $.extend({required: param}, data);
            }

            return data;
        }
    });

// Custom selectors
    $.extend($.expr[":"], {
        // http://docs.jquery.com/Plugins/Validation/blank
        blank: function( a ) { return !$.trim("" + $(a).val()); },
        // http://docs.jquery.com/Plugins/Validation/filled
        filled: function( a ) { return !!$.trim("" + $(a).val()); },
        // http://docs.jquery.com/Plugins/Validation/unchecked
        unchecked: function( a ) { return !$(a).prop("checked"); }
    });

// constructor for validator
    $.validator = function( options, form ) {
        this.settings = $.extend( true, {}, $.validator.defaults, options );
        this.currentForm = form;
        this.init();
    };

    $.validator.format = function( source, params ) {
        if ( arguments.length === 1 ) {
            return function() {
                var args = $.makeArray(arguments);
                args.unshift(source);
                return $.validator.format.apply( this, args );
            };
        }
        if ( arguments.length > 2 && params.constructor !== Array  ) {
            params = $.makeArray(arguments).slice(1);
        }
        if ( params.constructor !== Array ) {
            params = [ params ];
        }
        $.each(params, function( i, n ) {
            source = source.replace( new RegExp("\\{" + i + "\\}", "g"), function() {
                return n;
            });
        });
        return source;
    };

    $.extend($.validator, {

        defaults: {
            messages: {},
            groups: {},
            rules: {},
            errorClass: "error",
            validClass: "valid",
            errorElement: "label",
            focusInvalid: true,
            errorContainer: $([]),
            errorLabelContainer: $([]),
            onsubmit: true,
            ignore: ":hidden",
            ignoreTitle: false,
            onfocusin: function( element, event ) {
                this.lastActive = element;

                // hide error label and remove error class on focus if enabled
                if ( this.settings.focusCleanup && !this.blockFocusCleanup ) {
                    if ( this.settings.unhighlight ) {
                        this.settings.unhighlight.call( this, element, this.settings.errorClass, this.settings.validClass );
                    }
                    this.addWrapper(this.errorsFor(element)).hide();
                }
            },
            onfocusout: function( element, event ) {
                if ( !this.checkable(element) && (element.name in this.submitted || !this.optional(element)) ) {
                    this.element(element);
                }
            },
            onkeyup: function( element, event ) {
                if ( event.which === 9 && this.elementValue(element) === "" ) {
                    return;
                } else if ( element.name in this.submitted || element === this.lastElement ) {
                    this.element(element);
                }
            },
            onclick: function( element, event ) {
                // click on selects, radiobuttons and checkboxes
                if ( element.name in this.submitted ) {
                    this.element(element);
                }
                // or option elements, check parent select in that case
                else if ( element.parentNode.name in this.submitted ) {
                    this.element(element.parentNode);
                }
            },
            highlight: function( element, errorClass, validClass ) {
                if ( element.type === "radio" ) {
                    this.findByName(element.name).addClass(errorClass).removeClass(validClass);
                } else {
                    $(element).addClass(errorClass).removeClass(validClass);
                }
            },
            unhighlight: function( element, errorClass, validClass ) {
                if ( element.type === "radio" ) {
                    this.findByName(element.name).removeClass(errorClass).addClass(validClass);
                } else {
                    $(element).removeClass(errorClass).addClass(validClass);
                }
            }
        },

        // http://docs.jquery.com/Plugins/Validation/Validator/setDefaults
        setDefaults: function( settings ) {
            $.extend( $.validator.defaults, settings );
        },

        messages: {
            required: "This field is required.",
            remote: "Please fix this field.",
            email: "Please enter a valid email address.",
            url: "Please enter a valid URL.",
            date: "Please enter a valid date.",
            dateISO: "Please enter a valid date (ISO).",
            number: "Please enter a valid number.",
            digits: "Please enter only digits.",
            creditcard: "Please enter a valid credit card number.",
            equalTo: "Please enter the same value again.",
            maxlength: $.validator.format("Please enter no more than {0} characters."),
            minlength: $.validator.format("Please enter at least {0} characters."),
            rangelength: $.validator.format("Please enter a value between {0} and {1} characters long."),
            range: $.validator.format("Please enter a value between {0} and {1}."),
            max: $.validator.format("Please enter a value less than or equal to {0}."),
            min: $.validator.format("Please enter a value greater than or equal to {0}.")
        },

        autoCreateRanges: false,

        prototype: {

            init: function() {
                this.labelContainer = $(this.settings.errorLabelContainer);
                this.errorContext = this.labelContainer.length && this.labelContainer || $(this.currentForm);
                this.containers = $(this.settings.errorContainer).add( this.settings.errorLabelContainer );
                this.submitted = {};
                this.valueCache = {};
                this.pendingRequest = 0;
                this.pending = {};
                this.invalid = {};
                this.reset();

                var groups = (this.groups = {});
                $.each(this.settings.groups, function( key, value ) {
                    if ( typeof value === "string" ) {
                        value = value.split(/\s/);
                    }
                    $.each(value, function( index, name ) {
                        groups[name] = key;
                    });
                });
                var rules = this.settings.rules;
                $.each(rules, function( key, value ) {
                    rules[key] = $.validator.normalizeRule(value);
                });

                function delegate(event) {
                    var validator = $.data(this[0].form, "validator"),
                        eventType = "on" + event.type.replace(/^validate/, "");
                    if ( validator.settings[eventType] ) {
                        validator.settings[eventType].call(validator, this[0], event);
                    }
                }
                $(this.currentForm)
                    .validateDelegate(":text, [type='password'], [type='file'], select, textarea, " +
                        "[type='number'], [type='search'] ,[type='tel'], [type='url'], " +
                        "[type='email'], [type='datetime'], [type='date'], [type='month'], " +
                        "[type='week'], [type='time'], [type='datetime-local'], " +
                        "[type='range'], [type='color'] ",
                        "focusin focusout keyup", delegate)
                    .validateDelegate("[type='radio'], [type='checkbox'], select, option", "click", delegate);

                if ( this.settings.invalidHandler ) {
                    $(this.currentForm).bind("invalid-form.validate", this.settings.invalidHandler);
                }
            },

            // http://docs.jquery.com/Plugins/Validation/Validator/form
            form: function() {
                this.checkForm();
                $.extend(this.submitted, this.errorMap);
                this.invalid = $.extend({}, this.errorMap);
                if ( !this.valid() ) {
                    $(this.currentForm).triggerHandler("invalid-form", [this]);
                }
                this.showErrors();
                return this.valid();
            },

            checkForm: function() {
                this.prepareForm();
                for ( var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++ ) {
                    this.check( elements[i] );
                }
                return this.valid();
            },

            // http://docs.jquery.com/Plugins/Validation/Validator/element
            element: function( element ) {
                element = this.validationTargetFor( this.clean( element ) );
                this.lastElement = element;
                this.prepareElement( element );
                this.currentElements = $(element);
                var result = this.check( element ) !== false;
                if ( result ) {
                    delete this.invalid[element.name];
                } else {
                    this.invalid[element.name] = true;
                }
                if ( !this.numberOfInvalids() ) {
                    // Hide error containers on last error
                    this.toHide = this.toHide.add( this.containers );
                }
                this.showErrors();
                return result;
            },

            // http://docs.jquery.com/Plugins/Validation/Validator/showErrors
            showErrors: function( errors ) {
                if ( errors ) {
                    // add items to error list and map
                    $.extend( this.errorMap, errors );
                    this.errorList = [];
                    for ( var name in errors ) {
                        this.errorList.push({
                            message: errors[name],
                            element: this.findByName(name)[0]
                        });
                    }
                    // remove items from success list
                    this.successList = $.grep( this.successList, function( element ) {
                        return !(element.name in errors);
                    });
                }
                if ( this.settings.showErrors ) {
                    this.settings.showErrors.call( this, this.errorMap, this.errorList );
                } else {
                    this.defaultShowErrors();
                }
            },

            // http://docs.jquery.com/Plugins/Validation/Validator/resetForm
            resetForm: function() {
                if ( $.fn.resetForm ) {
                    $(this.currentForm).resetForm();
                }
                this.submitted = {};
                this.lastElement = null;
                this.prepareForm();
                this.hideErrors();
                this.elements().removeClass( this.settings.errorClass ).removeData( "previousValue" );
            },

            numberOfInvalids: function() {
                return this.objectLength(this.invalid);
            },

            objectLength: function( obj ) {
                var count = 0;
                for ( var i in obj ) {
                    count++;
                }
                return count;
            },

            hideErrors: function() {
                this.addWrapper( this.toHide ).hide();
            },

            valid: function() {
                return this.size() === 0;
            },

            size: function() {
                return this.errorList.length;
            },

            focusInvalid: function() {
                if ( this.settings.focusInvalid ) {
                    try {
                        $(this.findLastActive() || this.errorList.length && this.errorList[0].element || [])
                            .filter(":visible")
                            .focus()
                            // manually trigger focusin event; without it, focusin handler isn't called, findLastActive won't have anything to find
                            .trigger("focusin");
                    } catch(e) {
                        // ignore IE throwing errors when focusing hidden elements
                    }
                }
            },

            findLastActive: function() {
                var lastActive = this.lastActive;
                return lastActive && $.grep(this.errorList, function( n ) {
                    return n.element.name === lastActive.name;
                }).length === 1 && lastActive;
            },

            elements: function() {
                var validator = this,
                    rulesCache = {};

                // select all valid inputs inside the form (no submit or reset buttons)
                return $(this.currentForm)
                    .find("input, select, textarea")
                    .not(":submit, :reset, :image, [disabled]")
                    .not( this.settings.ignore )
                    .filter(function() {
                        if ( !this.name && validator.settings.debug && window.console ) {
                            console.error( "%o has no name assigned", this);
                        }

                        // select only the first element for each name, and only those with rules specified
                        if ( this.name in rulesCache || !validator.objectLength($(this).rules()) ) {
                            return false;
                        }

                        rulesCache[this.name] = true;
                        return true;
                    });
            },

            clean: function( selector ) {
                return $(selector)[0];
            },

            errors: function() {
                var errorClass = this.settings.errorClass.replace(" ", ".");
                return $(this.settings.errorElement + "." + errorClass, this.errorContext);
            },

            reset: function() {
                this.successList = [];
                this.errorList = [];
                this.errorMap = {};
                this.toShow = $([]);
                this.toHide = $([]);
                this.currentElements = $([]);
            },

            prepareForm: function() {
                this.reset();
                this.toHide = this.errors().add( this.containers );
            },

            prepareElement: function( element ) {
                this.reset();
                this.toHide = this.errorsFor(element);
            },

            elementValue: function( element ) {
                var type = $(element).attr("type"),
                    val = $(element).val();

                if ( type === "radio" || type === "checkbox" ) {
                    return $("input[name='" + $(element).attr("name") + "']:checked").val();
                }

                if ( typeof val === "string" ) {
                    return val.replace(/\r/g, "");
                }
                return val;
            },

            check: function( element ) {
                element = this.validationTargetFor( this.clean( element ) );

                var rules = $(element).rules();
                var dependencyMismatch = false;
                var val = this.elementValue(element);
                var result;

                for (var method in rules ) {
                    var rule = { method: method, parameters: rules[method] };
                    try {

                        result = $.validator.methods[method].call( this, val, element, rule.parameters );

                        // if a method indicates that the field is optional and therefore valid,
                        // don't mark it as valid when there are no other rules
                        if ( result === "dependency-mismatch" ) {
                            dependencyMismatch = true;
                            continue;
                        }
                        dependencyMismatch = false;

                        if ( result === "pending" ) {
                            this.toHide = this.toHide.not( this.errorsFor(element) );
                            return;
                        }

                        if ( !result ) {
                            this.formatAndAdd( element, rule );
                            return false;
                        }
                    } catch(e) {
                        if ( this.settings.debug && window.console ) {
                            console.log( "Exception occurred when checking element " + element.id + ", check the '" + rule.method + "' method.", e );
                        }
                        throw e;
                    }
                }
                if ( dependencyMismatch ) {
                    return;
                }
                if ( this.objectLength(rules) ) {
                    this.successList.push(element);
                }
                return true;
            },

            // return the custom message for the given element and validation method
            // specified in the element's HTML5 data attribute
            customDataMessage: function( element, method ) {
                return $(element).data("msg-" + method.toLowerCase()) || (element.attributes && $(element).attr("data-msg-" + method.toLowerCase()));
            },

            // return the custom message for the given element name and validation method
            customMessage: function( name, method ) {
                var m = this.settings.messages[name];
                return m && (m.constructor === String ? m : m[method]);
            },

            // return the first defined argument, allowing empty strings
            findDefined: function() {
                for(var i = 0; i < arguments.length; i++) {
                    if ( arguments[i] !== undefined ) {
                        return arguments[i];
                    }
                }
                return undefined;
            },

            defaultMessage: function( element, method ) {
                return this.findDefined(
                    this.customMessage( element.name, method ),
                    this.customDataMessage( element, method ),
                    // title is never undefined, so handle empty string as undefined
                    !this.settings.ignoreTitle && element.title || undefined,
                    $.validator.messages[method],
                    "<strong>Warning: No message defined for " + element.name + "</strong>"
                );
            },

            formatAndAdd: function( element, rule ) {
                var message = this.defaultMessage( element, rule.method ),
                    theregex = /\$?\{(\d+)\}/g;
                if ( typeof message === "function" ) {
                    message = message.call(this, rule.parameters, element);
                } else if (theregex.test(message)) {
                    message = $.validator.format(message.replace(theregex, "{$1}"), rule.parameters);
                }
                this.errorList.push({
                    message: message,
                    element: element
                });

                this.errorMap[element.name] = message;
                this.submitted[element.name] = message;
            },

            addWrapper: function( toToggle ) {
                if ( this.settings.wrapper ) {
                    toToggle = toToggle.add( toToggle.parent( this.settings.wrapper ) );
                }
                return toToggle;
            },

            defaultShowErrors: function() {
                var i, elements;
                for ( i = 0; this.errorList[i]; i++ ) {
                    var error = this.errorList[i];
                    if ( this.settings.highlight ) {
                        this.settings.highlight.call( this, error.element, this.settings.errorClass, this.settings.validClass );
                    }
                    this.showLabel( error.element, error.message );
                }
                if ( this.errorList.length ) {
                    this.toShow = this.toShow.add( this.containers );
                }
                if ( this.settings.success ) {
                    for ( i = 0; this.successList[i]; i++ ) {
                        this.showLabel( this.successList[i] );
                    }
                }
                if ( this.settings.unhighlight ) {
                    for ( i = 0, elements = this.validElements(); elements[i]; i++ ) {
                        this.settings.unhighlight.call( this, elements[i], this.settings.errorClass, this.settings.validClass );
                    }
                }
                this.toHide = this.toHide.not( this.toShow );
                this.hideErrors();
                this.addWrapper( this.toShow ).show();
            },

            validElements: function() {
                return this.currentElements.not(this.invalidElements());
            },

            invalidElements: function() {
                return $(this.errorList).map(function() {
                    return this.element;
                });
            },

            showLabel: function( element, message ) {
                var label = this.errorsFor( element );
                if ( label.length ) {
                    // refresh error/success class
                    label.removeClass( this.settings.validClass ).addClass( this.settings.errorClass );
                    // replace message on existing label
                    label.html(message);
                } else {
                    // create label
                    label = $("<" + this.settings.errorElement + ">")
                        .attr("for", this.idOrName(element))
                        .addClass(this.settings.errorClass)
                        .html(message || "");
                    if ( this.settings.wrapper ) {
                        // make sure the element is visible, even in IE
                        // actually showing the wrapped element is handled elsewhere
                        label = label.hide().show().wrap("<" + this.settings.wrapper + "/>").parent();
                    }
                    if ( !this.labelContainer.append(label).length ) {
                        if ( this.settings.errorPlacement ) {
                            this.settings.errorPlacement(label, $(element) );
                        } else {
                            label.insertAfter(element);
                        }
                    }
                }
                if ( !message && this.settings.success ) {
                    label.text("");
                    if ( typeof this.settings.success === "string" ) {
                        label.addClass( this.settings.success );
                    } else {
                        this.settings.success( label, element );
                    }
                }
                this.toShow = this.toShow.add(label);
            },

            errorsFor: function( element ) {
                var name = this.idOrName(element);
                return this.errors().filter(function() {
                    return $(this).attr("for") === name;
                });
            },

            idOrName: function( element ) {
                return this.groups[element.name] || (this.checkable(element) ? element.name : element.id || element.name);
            },

            validationTargetFor: function( element ) {
                // if radio/checkbox, validate first element in group instead
                if ( this.checkable(element) ) {
                    element = this.findByName( element.name ).not(this.settings.ignore)[0];
                }
                return element;
            },

            checkable: function( element ) {
                return (/radio|checkbox/i).test(element.type);
            },

            findByName: function( name ) {
                return $(this.currentForm).find("[name='" + name + "']");
            },

            getLength: function( value, element ) {
                switch( element.nodeName.toLowerCase() ) {
                    case "select":
                        return $("option:selected", element).length;
                    case "input":
                        if ( this.checkable( element) ) {
                            return this.findByName(element.name).filter(":checked").length;
                        }
                }
                return value.length;
            },

            depend: function( param, element ) {
                return this.dependTypes[typeof param] ? this.dependTypes[typeof param](param, element) : true;
            },

            dependTypes: {
                "boolean": function( param, element ) {
                    return param;
                },
                "string": function( param, element ) {
                    return !!$(param, element.form).length;
                },
                "function": function( param, element ) {
                    return param(element);
                }
            },

            optional: function( element ) {
                var val = this.elementValue(element);
                return !$.validator.methods.required.call(this, val, element) && "dependency-mismatch";
            },

            startRequest: function( element ) {
                if ( !this.pending[element.name] ) {
                    this.pendingRequest++;
                    this.pending[element.name] = true;
                }
            },

            stopRequest: function( element, valid ) {
                this.pendingRequest--;
                // sometimes synchronization fails, make sure pendingRequest is never < 0
                if ( this.pendingRequest < 0 ) {
                    this.pendingRequest = 0;
                }
                delete this.pending[element.name];
                if ( valid && this.pendingRequest === 0 && this.formSubmitted && this.form() ) {
                    $(this.currentForm).submit();
                    this.formSubmitted = false;
                } else if (!valid && this.pendingRequest === 0 && this.formSubmitted) {
                    $(this.currentForm).triggerHandler("invalid-form", [this]);
                    this.formSubmitted = false;
                }
            },

            previousValue: function( element ) {
                return $.data(element, "previousValue") || $.data(element, "previousValue", {
                    old: null,
                    valid: true,
                    message: this.defaultMessage( element, "remote" )
                });
            }

        },

        classRuleSettings: {
            required: {required: true},
            email: {email: true},
            url: {url: true},
            date: {date: true},
            dateISO: {dateISO: true},
            number: {number: true},
            digits: {digits: true},
            creditcard: {creditcard: true}
        },

        addClassRules: function( className, rules ) {
            if ( className.constructor === String ) {
                this.classRuleSettings[className] = rules;
            } else {
                $.extend(this.classRuleSettings, className);
            }
        },

        classRules: function( element ) {
            var rules = {};
            var classes = $(element).attr("class");
            if ( classes ) {
                $.each(classes.split(" "), function() {
                    if ( this in $.validator.classRuleSettings ) {
                        $.extend(rules, $.validator.classRuleSettings[this]);
                    }
                });
            }
            return rules;
        },

        attributeRules: function( element ) {
            var rules = {};
            var $element = $(element);
            var type = $element[0].getAttribute("type");

            for (var method in $.validator.methods) {
                var value;

                // support for <input required> in both html5 and older browsers
                if ( method === "required" ) {
                    value = $element.get(0).getAttribute(method);
                    // Some browsers return an empty string for the required attribute
                    // and non-HTML5 browsers might have required="" markup
                    if ( value === "" ) {
                        value = true;
                    }
                    // force non-HTML5 browsers to return bool
                    value = !!value;
                } else {
                    value = $element.attr(method);
                }

                // convert the value to a number for number inputs, and for text for backwards compability
                // allows type="date" and others to be compared as strings
                if ( /min|max/.test( method ) && ( type === null || /number|range|text/.test( type ) ) ) {
                    value = Number(value);
                }

                if ( value ) {
                    rules[method] = value;
                } else if ( type === method && type !== 'range' ) {
                    // exception: the jquery validate 'range' method
                    // does not test for the html5 'range' type
                    rules[method] = true;
                }
            }

            // maxlength may be returned as -1, 2147483647 (IE) and 524288 (safari) for text inputs
            if ( rules.maxlength && /-1|2147483647|524288/.test(rules.maxlength) ) {
                delete rules.maxlength;
            }

            return rules;
        },

        dataRules: function( element ) {
            var method, value,
                rules = {}, $element = $(element);
            for (method in $.validator.methods) {
                value = $element.data("rule-" + method.toLowerCase());
                if ( value !== undefined ) {
                    rules[method] = value;
                }
            }
            return rules;
        },

        staticRules: function( element ) {
            var rules = {};
            var validator = $.data(element.form, "validator");
            if ( validator.settings.rules ) {
                rules = $.validator.normalizeRule(validator.settings.rules[element.name]) || {};
            }
            return rules;
        },

        normalizeRules: function( rules, element ) {
            // handle dependency check
            $.each(rules, function( prop, val ) {
                // ignore rule when param is explicitly false, eg. required:false
                if ( val === false ) {
                    delete rules[prop];
                    return;
                }
                if ( val.param || val.depends ) {
                    var keepRule = true;
                    switch (typeof val.depends) {
                        case "string":
                            keepRule = !!$(val.depends, element.form).length;
                            break;
                        case "function":
                            keepRule = val.depends.call(element, element);
                            break;
                    }
                    if ( keepRule ) {
                        rules[prop] = val.param !== undefined ? val.param : true;
                    } else {
                        delete rules[prop];
                    }
                }
            });

            // evaluate parameters
            $.each(rules, function( rule, parameter ) {
                rules[rule] = $.isFunction(parameter) ? parameter(element) : parameter;
            });

            // clean number parameters
            $.each(['minlength', 'maxlength'], function() {
                if ( rules[this] ) {
                    rules[this] = Number(rules[this]);
                }
            });
            $.each(['rangelength', 'range'], function() {
                var parts;
                if ( rules[this] ) {
                    if ( $.isArray(rules[this]) ) {
                        rules[this] = [Number(rules[this][0]), Number(rules[this][1])];
                    } else if ( typeof rules[this] === "string" ) {
                        parts = rules[this].split(/[\s,]+/);
                        rules[this] = [Number(parts[0]), Number(parts[1])];
                    }
                }
            });

            if ( $.validator.autoCreateRanges ) {
                // auto-create ranges
                if ( rules.min && rules.max ) {
                    rules.range = [rules.min, rules.max];
                    delete rules.min;
                    delete rules.max;
                }
                if ( rules.minlength && rules.maxlength ) {
                    rules.rangelength = [rules.minlength, rules.maxlength];
                    delete rules.minlength;
                    delete rules.maxlength;
                }
            }

            return rules;
        },

        // Converts a simple string to a {string: true} rule, e.g., "required" to {required:true}
        normalizeRule: function( data ) {
            if ( typeof data === "string" ) {
                var transformed = {};
                $.each(data.split(/\s/), function() {
                    transformed[this] = true;
                });
                data = transformed;
            }
            return data;
        },

        // http://docs.jquery.com/Plugins/Validation/Validator/addMethod
        addMethod: function( name, method, message ) {
            $.validator.methods[name] = method;
            $.validator.messages[name] = message !== undefined ? message : $.validator.messages[name];
            if ( method.length < 3 ) {
                $.validator.addClassRules(name, $.validator.normalizeRule(name));
            }
        },

        methods: {

            // http://docs.jquery.com/Plugins/Validation/Methods/required
            required: function( value, element, param ) {
                // check if dependency is met
                if ( !this.depend(param, element) ) {
                    return "dependency-mismatch";
                }
                if ( element.nodeName.toLowerCase() === "select" ) {
                    // could be an array for select-multiple or a string, both are fine this way
                    var val = $(element).val();
                    return val && val.length > 0;
                }
                if ( this.checkable(element) ) {
                    return this.getLength(value, element) > 0;
                }
                return $.trim(value).length > 0;
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/email
            email: function( value, element ) {
                // contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
                return this.optional(element) || /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(value);
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/url
            url: function( value, element ) {
                // contributed by Scott Gonzalez: http://projects.scottsplayground.com/iri/
                return this.optional(element) || /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value);
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/date
            date: function( value, element ) {
                return this.optional(element) || !/Invalid|NaN/.test(new Date(value).toString());
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/dateISO
            dateISO: function( value, element ) {
                return this.optional(element) || /^\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2}$/.test(value);
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/number
            number: function( value, element ) {
                return this.optional(element) || /^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(value);
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/digits
            digits: function( value, element ) {
                return this.optional(element) || /^\d+$/.test(value);
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/creditcard
            // based on http://en.wikipedia.org/wiki/Luhn
            creditcard: function( value, element ) {
                if ( this.optional(element) ) {
                    return "dependency-mismatch";
                }
                // accept only spaces, digits and dashes
                if ( /[^0-9 \-]+/.test(value) ) {
                    return false;
                }
                var nCheck = 0,
                    nDigit = 0,
                    bEven = false;

                value = value.replace(/\D/g, "");

                for (var n = value.length - 1; n >= 0; n--) {
                    var cDigit = value.charAt(n);
                    nDigit = parseInt(cDigit, 10);
                    if ( bEven ) {
                        if ( (nDigit *= 2) > 9 ) {
                            nDigit -= 9;
                        }
                    }
                    nCheck += nDigit;
                    bEven = !bEven;
                }

                return (nCheck % 10) === 0;
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/minlength
            minlength: function( value, element, param ) {
                var length = $.isArray( value ) ? value.length : this.getLength($.trim(value), element);
                return this.optional(element) || length >= param;
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/maxlength
            maxlength: function( value, element, param ) {
                var length = $.isArray( value ) ? value.length : this.getLength($.trim(value), element);
                return this.optional(element) || length <= param;
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/rangelength
            rangelength: function( value, element, param ) {
                var length = $.isArray( value ) ? value.length : this.getLength($.trim(value), element);
                return this.optional(element) || ( length >= param[0] && length <= param[1] );
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/min
            min: function( value, element, param ) {
                return this.optional(element) || value >= param;
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/max
            max: function( value, element, param ) {
                return this.optional(element) || value <= param;
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/range
            range: function( value, element, param ) {
                return this.optional(element) || ( value >= param[0] && value <= param[1] );
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/equalTo
            equalTo: function( value, element, param ) {
                // bind to the blur event of the target in order to revalidate whenever the target field is updated
                // TODO find a way to bind the event just once, avoiding the unbind-rebind overhead
                var target = $(param);
                if ( this.settings.onfocusout ) {
                    target.unbind(".validate-equalTo").bind("blur.validate-equalTo", function() {
                        $(element).valid();
                    });
                }
                return value === target.val();
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/remote
            remote: function( value, element, param ) {
                if ( this.optional(element) ) {
                    return "dependency-mismatch";
                }

                var previous = this.previousValue(element);
                if (!this.settings.messages[element.name] ) {
                    this.settings.messages[element.name] = {};
                }
                previous.originalMessage = this.settings.messages[element.name].remote;
                this.settings.messages[element.name].remote = previous.message;

                param = typeof param === "string" && {url:param} || param;

                if ( previous.old === value ) {
                    return previous.valid;
                }

                previous.old = value;
                var validator = this;
                this.startRequest(element);
                var data = {};
                data[element.name] = value;
                $.ajax($.extend(true, {
                    url: param,
                    mode: "abort",
                    port: "validate" + element.name,
                    dataType: "json",
                    data: data,
                    success: function( response ) {
                        validator.settings.messages[element.name].remote = previous.originalMessage;
                        var valid = response === true || response === "true";
                        if ( valid ) {
                            var submitted = validator.formSubmitted;
                            validator.prepareElement(element);
                            validator.formSubmitted = submitted;
                            validator.successList.push(element);
                            delete validator.invalid[element.name];
                            validator.showErrors();
                        } else {
                            var errors = {};
                            var message = response || validator.defaultMessage( element, "remote" );
                            errors[element.name] = previous.message = $.isFunction(message) ? message(value) : message;
                            validator.invalid[element.name] = true;
                            validator.showErrors(errors);
                        }
                        previous.valid = valid;
                        validator.stopRequest(element, valid);
                    }
                }, param));
                return "pending";
            }

        }

    });

// deprecated, use $.validator.format instead
    $.format = $.validator.format;

}(jQuery));

// ajax mode: abort
// usage: $.ajax({ mode: "abort"[, port: "uniqueport"]});
// if mode:"abort" is used, the previous request on that port (port can be undefined) is aborted via XMLHttpRequest.abort()
(function($) {
    var pendingRequests = {};
    // Use a prefilter if available (1.5+)
    if ( $.ajaxPrefilter ) {
        $.ajaxPrefilter(function( settings, _, xhr ) {
            var port = settings.port;
            if ( settings.mode === "abort" ) {
                if ( pendingRequests[port] ) {
                    pendingRequests[port].abort();
                }
                pendingRequests[port] = xhr;
            }
        });
    } else {
        // Proxy ajax
        var ajax = $.ajax;
        $.ajax = function( settings ) {
            var mode = ( "mode" in settings ? settings : $.ajaxSettings ).mode,
                port = ( "port" in settings ? settings : $.ajaxSettings ).port;
            if ( mode === "abort" ) {
                if ( pendingRequests[port] ) {
                    pendingRequests[port].abort();
                }
                pendingRequests[port] = ajax.apply(this, arguments);
                return pendingRequests[port];
            }
            return ajax.apply(this, arguments);
        };
    }
}(jQuery));

// provides delegate(type: String, delegate: Selector, handler: Callback) plugin for easier event delegation
// handler is only called when $(event.target).is(delegate), in the scope of the jquery-object for event.target
(function($) {
    $.extend($.fn, {
        validateDelegate: function( delegate, type, handler ) {
            return this.bind(type, function( event ) {
                var target = $(event.target);
                if ( target.is(delegate) ) {
                    return handler.apply(target, arguments);
                }
            });
        }
    });
}(jQuery));

jQuery( document ).ready(function () {
    jQuery('#save_sponsor').validate({
        rules : {
            "data[Sponsor][nombre_sponsor]" : {
                required: true,
                minlength : 2




            }

        }
    });

    jQuery('.bot_envnuevoproy').click(function(){
        if(jQuery('#save_sponsor').valid() == true){
            jQuery('#save_sponsor').submit();

        };

    });



    jQuery('#form_upload_imgsponsor').validate({
        rules : {
            x1 : {
                required: true

            },
            y1 : {
                required: true

            }

        }
    });

    jQuery('.bot_envnuevoproy').click(function(){
        if(jQuery('#form_upload_imgsponsor').valid() == true){
            jQuery('#form_upload_imgsponsor').submit();

        };

    });

});

</script-->
<?php

$this->set('pageTitle' , __("Browse_sponsor",$return = true));
$this->set('title_for_layout' ,__("Browse_sponsor",$return = true));



//session_start(); //Do not remove this
//only assign a new timestamp if the session variable is empty
if (!isset($_SESSION['random_key']) || strlen($_SESSION['random_key'])==0){
    $_SESSION['random_key'] = strtotime(date('Y-m-d H:i:s')); //assign the timestamp to the session variable
    $_SESSION['user_file_ext']= "";
}
#########################################################################################################
# CONSTANTS																								#
# You can alter the options below																		#
#########################################################################################################

$upload_dir = "../webroot/upload_sponsors"; 				// The directory for the images to be saved in
$upload_path = $upload_dir."/";				// The path to where the image will be saved
//$image_handling_file = "vendors/crop/image_handling.php"; // The location of the file that will handle the upload and resizing (RELATIVE PATH ONLY!)
$large_image_prefix = "resize_"; 			// The prefix name to large image
$thumb_image_prefix = "thumbnail_";			// The prefix name to the thumb image
$large_image_name = $large_image_prefix.$_SESSION['random_key'];     // New name of the large image (append the timestamp to the filename)
$thumb_image_name = $thumb_image_prefix.$_SESSION['random_key'];     // New name of the thumbnail image (append the timestamp to the filename)
$max_file = "1"; 							// Maximum file size in MB
$max_width = "500";							// Max width allowed for the large image
$thumb_width = "250";						// Width of thumbnail image
$thumb_height = "100";						// Height of thumbnail image
// Only one of these image types should be allowed for upload
$allowed_image_types = array('image/pjpeg'=>"jpg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png",'image/x-png'=>"png",'image/gif'=>"gif");
$allowed_image_ext = array_unique($allowed_image_types); // Do not change this
$image_ext = "";
foreach ($allowed_image_ext as $mime_type => $ext) {
    $image_ext.= strtoupper($ext)." ";
}
?>
<?

?>

<div class="contenedor_sponsor">
<script type="text/javascript">
function showTip(e,user){
    var pos=getAbsolutePosMouse(e);
    $('tip').innerHTML=user;
    $('tip').style.top=pos.y+10+'px';
    if(pos.x<(document.body.offsetWidth/2))
        $('tip').style.left=pos.x+10+'px';
    else
        $('tip').style.left=pos.x-$('tip').offsetWidth-10+'px';
}
function hideTip(){
    $('tip').innerHTML='';
    $('tip').style.top='-1500px';
}

    function crop() {

        jQuery('#loader').hide();
        jQuery('#progress').hide();

        var myUpload = jQuery('#upload_link').upload({
            name: 'image',
            action: '/projects/testcropadmin',
            enctype: 'multipart/form-data',
            params: {upload:'Upload'},
            autoSubmit: true,
            onSubmit: function() {

                jQuery('#upload_status').html('').hide();
                loadingmessage('Please wait, uploading file...', 'show');
            },
            onComplete: function(response) {
                var img_time = '?'+Math.round(Math.random()*1000);

                loadingmessage('', 'hide');
                //response = unescape(response);
                var response_new = jQuery.parseJSON(response);

                var regular_url = response_new.regular.ubicacion;

                regular_url = regular_url.split("../webroot/upload_sponsors/");
                var thumb_url = response_new.thumbs.ubicacion;
                thumb_url = thumb_url.split("../webroot/upload_sponsors/");

                /*var thumbname = response.split("thumbnail_");
                var response = response.split("|");
                var responseType = response[0];
                var responseMsg = response[1];*/
                //var new_response = responseMsg.split("../webroot/image/transfer/project/tmp/img/");
                //var new_response2 = thumbname.split("");


                if(regular_url != ''){
                    var current_width = response_new.regular.width;
                    var current_height = response_new.regular.height;


                    //display message that the file has been uploaded
                    jQuery('#upload_status').show().html('<h1>Success</h1><p>The image has been uploaded</p>');
                    //put the image in the appropriate div
                    jQuery('#uploaded_image').html('<img src="/upload_sponsors/'+regular_url[1]+img_time+'" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" /><div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;"> <img src="/upload_sponsors/'+regular_url[1]+img_time+'" style="position: relative;" id="thumbnail_preview" alt="Thumbnail Preview" /></div>');
                    //find the image inserted above, and allow it to be cropped
                    jQuery('#uploaded_image').find('#thumbnail').imgAreaSelect({handles: true,parent:'#uploaded_image', aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview });
                    //display the hidden form
                    jQuery('#thumbnail_form').show();

                    jQuery('#upload2').attr("value",thumb_url[1]);
                    //jQuery('#upload2').attr("value",thumb_url[1]);
                }else if(responseType=="error"){
                    jQuery('#upload_status').show().html('<h1>Error</h1><p>'+responseMsg+'</p>');
                    jQuery('#uploaded_image').html('');
                    jQuery('#thumbnail_form').hide();
                }else{
                    jQuery('#upload_status').show().html('<h1>Unexpected Error</h1><p>Please try again</p>'+response);
                    jQuery('#uploaded_image').html('');
                    jQuery('#thumbnail_form').hide();
                }
            }
        });

        //create the thumbnail
        jQuery('#save_thumb').click(function() {
            var x1 = jQuery('#x1').val();
            var y1 = jQuery('#y1').val();
            var x2 = jQuery('#x2').val();
            var y2 = jQuery('#y2').val();
            var w = jQuery('#w').val();
            var h = jQuery('#h').val();
            if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
                alert("You must make a selection first");
                return false;
            }else{
                //hide the selection and disable the imgareaselect plugin
                jQuery('#uploaded_image').find('#thumbnail').imgAreaSelect({handles: true,parent:'#uploaded_image', disable: true, hide: true });
                loadingmessage('Please wait, saving thumbnail....', 'show');
                jQuery.ajax({
                    type: 'POST',
                    url: '/projects/testcropadmin',
                    data: 'save_thumb=Save Thumbnail&x1='+x1+'&y1='+y1+'&x2='+x2+'&y2='+y2+'&w='+w+'&h='+h,
                    cache: false,
                    success: function(response){
                        loadingmessage('', 'hide');
                        response = unescape(response);
                        var response = response.split("|");
                        var responseType = response[0];
                        var responseLargeImage = response[1];
                        var responseThumbImage = response[2];
                        if(responseType=="success"){
                            jQuery('#upload_status').show().html('<h1>Success</h1><p>The thumbnail has been saved!</p>');
                            //load the new images
                            //jQuery('#uploaded_image').html('<img src="'+responseLargeImage+'" alt="Large Image"/>&nbsp;<img src="'+responseThumbImage+'" alt="Thumbnail Image"/><br /><a href="javascript:deleteimage(\''+responseLargeImage+'\', \''+responseThumbImage+'\');">Delete Images</a>');
                            //hide the thumbnail form
                            jQuery('#thumbnail_form').hide();
                        }else{
                            jQuery('#upload_status').show().html('<h1>Unexpected Error</h1><p>Please try again</p>'+response);
                            //reactivate the imgareaselect plugin to allow another attempt.
                            jQuery('#uploaded_image').find('#thumbnail').imgAreaSelect({handles: true, parent:'#uploaded_image',aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview });
                            jQuery('#thumbnail_form').show();
                        }
                    }
                });

                return false;
            }
        });
    }





    DR(function(){

        crop();

    });
    DR(function(){

        crop();

    });
    //<![CDATA[

    //create a preview of the selection
    function preview(img, selection) {

        //get width and height of the uploaded image.
        var current_width = jQuery('#uploaded_image').find('#thumbnail').width();
        var current_height = jQuery('#uploaded_image').find('#thumbnail').height();


        var scaleX = <?php echo $thumb_width;?> / selection.width;
        var scaleY = <?php echo $thumb_height;?> / selection.height;

        jQuery('#uploaded_image').find('#thumbnail_preview').css({
            width: Math.round(scaleX * current_width) + 'px',
            height: Math.round(scaleY * current_height) + 'px',
            marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
            marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
        });
        jQuery('#x1').val(selection.x1);
        jQuery('#y1').val(selection.y1);
        jQuery('#x2').val(selection.x2);
        jQuery('#y2').val(selection.y2);
        jQuery('#w').val(selection.width);
        jQuery('#h').val(selection.height);
    }

    //show and hide the loading message
    function loadingmessage(msg, show_hide){
        if(show_hide=="show"){
            jQuery('#loader').show();
            jQuery('#progress').show().text(msg);
            jQuery('#uploaded_image').html('');
        }else if(show_hide=="hide"){
            jQuery('#loader').hide();
            jQuery('#progress').text('').hide();
        }else{
            jQuery('#loader').hide();
            jQuery('#progress').text('').hide();
            jQuery('#uploaded_image').html('');
        }
    }

    //delete the image when the delete link is clicked.
    function deleteimage(large_image, thumbnail_image){
        loadingmessage('Please wait, deleting images...', 'show');
        jQuery.ajax({
            type: 'POST',
            url: '/projects/testcropadmin',
            data: 'a=delete&large_image='+large_image+'&thumbnail_image='+thumbnail_image,
            cache: false,
            success: function(response){
                loadingmessage('', 'hide');
                response = unescape(response);
                var response = response.split("|");
                var responseType = response[0];
                var responseMsg = response[1];
                if(responseType=="success"){
                    jQuery('#upload_status').show().html('<h1>Success</h1><p>'+responseMsg+'</p>');
                    jQuery('#uploaded_image').html('');
                }else{
                    jQuery('#upload_status').show().html('<h1>Unexpected Error</h1><p>Please try again</p>'+response);
                }
            }
        });
    }








    //]]>
</script>


<div class="datos_proyecto_sponsor">

    <h1 style="font-family:"signika_negativeregular";color: #505050">UPLOAD IMAGENES PARA SPONSORS</h1>
    <div class="misc_separador" style="width:100%;margin-bottom: 25px"></div>
    <ul>
        <li><h3>TITULO PROYECTO</h3></li>

        <li><h3>AUTOR PROYECTO</h3></li>

        <li><h4><?=$Project['Project']['title'];?></h4></li>

        <li><h4><?=$Project['User']['display_name'];?></h4></li>


    </ul>

</div>
<div style="   display: block;
    font-size: 10px;
    height: 70px;
    margin-top: 70px;
    position: relative;
    width: 224px;">

    <h1>NOMBRE DEL SPONSOR</h1>


</div>
<div style="display: block;left: 195px;top: 300px;" class="bot_info"  onmouseout="hideTip()" onmousemove="showTip(event,'<?php echo __("IMAGEN_SPONSOR_INFO");?>')"></div>
<h1 style="font-size: 20px; margin-top:50px; margin-bottom: 20px"><?echo __("Browse");?></h1>
<!--noscript>Javascript must be enabled!</noscript>
<h2>Upload Photo</h2-->
<div id="upload_status" style="font-size:12px; width:40%; margin:10px; padding:5px; display:none; border:1px #999 dotted; background:#eee;"></div>
<p><a id="upload_link" style="position:relative;display: block;background:#000000;text-align: center;padding-top: 5px; font-size: 16px; color: white;width: 120px; height: 25px" href="#"><?echo __("UPLOAD_BROWSE");?></a></p>
<span id="loader" style="display:none;"><img src="/2012/images/loader.gif" alt="Loading..."/></span> <span id="progress"></span>
<br />
<div id="uploaded_image" style="float: left; position: relative; width: 900px; height: auto; display: block"></div>
<div id="thumbnail_form" style="display:none;">


    <input style="background: #559731!important;width: 100px;border-radius:2px 2px 2px 2px; margin-left:0px  " type="submit" name="save_thumb" value="Save Thumbnail" id="save_thumb"/>

</div>

<form id="form_upload_imgsponsor" name="form" action="" method="post">

    <input type="hidden" name="x1" value="" id="x1" />
    <input type="hidden" name="y1" value="" id="y1" />
    <input type="hidden" name="x2" value="" id="x2" />
    <input type="hidden" name="y2" value="" id="y2" />
    <input type="hidden" name="w" value="" id="w" />
    <input type="hidden" name="h" value="" id="h" />


</form>



<form id="save_sponsor"  method="post" action="/projects/adminuploadimage" accept-charset="utf-8">

    <input type="text" value="<?=$Project['Sponsor']['nombre_sponsor'];?>" name="data[Sponsor][nombre_sponsor]" id="upload3">
    <input type="hidden" value="<?=$Project['Project']['id'];?>" name="data[Sponsor][id_project]" id="sponsor">
    <input type="hidden" value="" name="data[Sponsor][basename]" id="upload2">
    <input type="hidden" value="<?=$control;?>" name="data[Sponsor][control]" id="upload4">
    <!--input type="submit" name="save_imagen" value="save"/-->
</form>
<script>

</script>
<div id="spon" style="height: 550px; display: none"></div>
<a onclick="$('save_sponsor').submit();return false;" class="bot_envnuevoproy" style="float:left;display: block;height: 37px;position: relative;width: 140px;" href="#"><?php echo __("SEND");?></a>
<div class="misc_separador" style="width:100%;position: relative; float: left "></div>


<ul style="float: left; display: block; width: 100%; list-style: none">

    <?php if (isset($show_sponsor)){

    foreach ($show_sponsor as $k => $v){?>

        <?$img=str_ireplace('.jpg','.png',$v["Sponsor"]["basename"]);?>

       <!--li style="float: left"><?echo $v['Sponsor']['id_project'];?></li-->
       <li style="width: 230px; display: block;margin-bottom: 10px; margin-top: 10px "><?= $v['Sponsor']['nombre_sponsor'];?></li>
       <li style="border:2px solid #0066cc;margin:10px 10px 10px 10px ;float: left;height: 121px;list-style: none ;width: 336px;"><img src="/upload_sponsors/<?echo $img;?>"/> </li>
       <a style="border:;width:50px!important;left: -25px;top: 115px;" class="delproy" href="/projects/delete_sponsor/<?=$v['Sponsor']['id'].'/'.$control?>"><span class="delp"></span>Borrar</a>

    <?}
}?>

    </ul>

   </div>
