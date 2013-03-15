<?php /* @var $this ViewCC */ ?>

<div style="overflow:hiddden;">
<?
if (!$this->params['isAjax']) {

    echo $this->element('users/profile', array('user' => $this->data));


    echo $this->element('users/profile_menu', array('section' => $section, 'user' => $this->data));
    ?>

    <div style=" float : right ; width : 720px ;   margin-top: 40px ;" class="feed-content" >
        <?
    }
    switch ($section) {
        case 'activity':
        case 'wall':
            echo $this->element('notifications/list', array('type' => 'user_feed', 'section' => $section, 'data' => $this->data));
            break;
        case 'projects':
			echo $this->element('projects/list', array('type' => 'profile_project', 'data' => $this->data));
            break;
        case 'offers':
            echo $this->element('offers/list', array('type' => 'profile_offer', 'data' => $this->data));
            break;
        case 'follows':
            echo $this->element('follows/list', array('type' => 'profile_follow', 'data' => $this->data));
            break;
        case 'sponsorships':
            echo $this->element('sponsorships/list', array('type' => 'profile_project', 'data' => $this->data));
            break;
        default:
            echo 'THIS SECTION DOES NOT EXIST';
            break;
    }
    ?>

    <? if ($this->Paginator->hasNext()) { ?>
        <div class="infinite-scroll paging">
            <?= $this->Paginator->next(__('MORE',true),array(),false); ?>
        </div>
        <? if ($this->params['isAjax']) { ?>   
            <script type="text/javascript">loadMore();</script>

        <? } ?>
    <? } ?>
    <? if (!$this->params['isAjax']) { ?>      
        <cake:script>
            <script type="text/javascript">
                /* Get the TOP position of a given element. */
                function getPositionTop(element){
                    var offset = 0;
                    while(element) {
                        offset += element.attr("offsetTop");
                        element = element.offsetParent ;
                    }
                    return offset;
                }

                /* Is a given element is visible or not? */
                function isElementVisible(eltId) {
                    var elt = $(eltId);
                    if (!elt.length ) {
                        return false;
                    }
                    var posTop = $(elt).offset().top;
                    var posBottom = posTop + $(elt).height();
                    var visibleTop = document.body.scrollTop;
                    var visibleBottom = visibleTop + document.documentElement.offsetHeight;
                    return ((posBottom >= visibleTop) && (posTop <= visibleBottom));
                }
                                                            
                function loadMore() {
                    if (isElementVisible('.infinite-scroll.paging')) {
                                                                     
                        if ($('.infinite-scroll.paging a').length >= 1 ){
                            currentPaging = $('.infinite-scroll.paging a') ;
                            url = currentPaging.attr('href');
                            currentPaging.parents('div.infinite-scroll').remove();
                            $.get(url,function(response){
                                $('.feed-content').append(response);
                                                                       
                            });
                        }
                    }
                }

                $(window).scroll(function(){
                    loadMore();
                }); 
                                                            
                loadMore();                                   
                                                            
                                                            
            </script>
        </cake:script>

    </div>
<? } ?>
</div>




