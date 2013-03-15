<html>
    <body>

        <script type="text/javascript" src="http://sn.gv/cjs/framework.js"></script>

        <textarea id="text1" style="width:100%;height:100px"></textarea>
        <div id="text2" style="width:100%;height:100px"></div>
        <div id="text3" style="width:100%;height:100px"></div>

        <div id="text4" style="width:100%;height:100px"></div>
        <div id="text5" style="width:100%;height:100px"></div>



        <script type="text/javascript">
            morce = new Array();
            morce['a'] = '* -';
            morce['b'] = '- * * *';
            morce['c'] = '- * - *';
            morce['d'] = '- * *';
            morce['e'] = '*';
            morce['f'] = '* * - *';
            morce['g'] = '- - *';
            morce['h'] = '* * * *';
            morce['i'] = '* *';
            //      morce['ä'] = '* - * -';
            //       morce['à'] = '* - - * -';
            morce['ç'] = '- * - * *';
            morce['ch'] = '- - - -';
            //    morce['ð'] = '* * - - *';
            //    morce['è'] = '* - * * -';
            //   morce['é'] = '* * - * *';
            morce['g'] = '- - * - *';
            morce['j'] = '* - - - *';
            morce['ñ'] = '- - * - -';
            //  morce['ö'] = '- - - *';
            morce['s'] = '* * * - *';
            //   morce['þ'] = '* - - * *';
            //   morce['ü'] = '* * - -';
            morce[':'] = '--- * * *';
            morce[';'] = '- * - * - *';
            morce['= '] = '- * * * -';
            morce['+'] = '* - * - *';
            morce['-'] = '- * * * * -';
            morce['_'] = '* * -- * -';
            morce['"'] = '* - * * - *';
            morce['$'] = '* * * - * * -';
            morce['@'] = '* -- * - *';
            morce['.'] = '* - * - * -';
            morce[','] = '-- * * --';
            morce['?'] = '* * -- * *';
            morce['\''] = '* ---- *';
            morce['!'] = '- * - * --';
            morce['/'] = '- * * - *';
            morce['('] = '- * - - *';
            morce[')'] = '- * -- * -';
            morce['&'] = '* - * * *';
            morce['1'] = '* - - - -';
            morce['2'] = '* * - - -';
            morce['3'] = '* * * - -';
            morce['4'] = '* * * * -';
            morce['5'] = '* * * * *';
            morce['6'] = '- * * * *';
            morce['7'] = '- - * * *';
            morce['8'] = '- - - * *';
            morce['9'] = '- - - - *';
            morce['s'] = '* * *';
            morce['t'] = '-';
            morce['u'] = '* * -';
            morce['v'] = '* * * -';
            morce['w'] = '* - -';
            morce['x'] = '- * * -';
            morce['y'] = '- * - -';
            morce['z'] = '- - * *';
            morce['0'] = '- - - - -';
            morce['j'] = '* - - -';
            morce['k'] = '- * -';
            morce['l'] = '* - * *';
            morce['m'] = '- -';
            morce['n'] = '- *';
            morce['o'] = '- - -';
            morce['p'] = '* - - *';
            morce['q'] = '- - * -';
            morce['r'] = '* - *';


            murcielago = new Array();
            murcielago['m'] = 0 ;
            murcielago['u'] = 1 ;
            murcielago['r'] = 2 ;
            murcielago['c'] = 3 ;
            murcielago['i'] = 4 ;
            murcielago['e'] = 5 ;
            murcielago['l'] = 6 ;
            murcielago['a'] = 7 ;
            murcielago['g'] = 8 ;
            murcielago['o'] = 9 ;

            cenitPolar = new Array();
            cenitPolar['c'] = 'p' ;
            cenitPolar['e'] = 'o' ;
            cenitPolar['n'] = 'l' ;
            cenitPolar['i'] = 'a' ;
            cenitPolar['t'] = 'r' ;

            $('#text1').bind("keyup",
            function(){
                
                text = $(this).val().toLowerCase().split('');
               
                newText =  $('#text1').val().replace(/([aeiouáéíóú])/g,'$1p$1').split('') ;
                o = '';
                for( character in newText){
                    o +=  '<span class="letter">' +(  newText[character] ) +    '</span>';
                }
               
                $('#text2').html( o );
               

                newText = '';
                for( character in text){
                    //( 
                    newText += '<span class="letter">' + ( morce[ text[character] ] ? morce[ text[character] ]:  text[character]  )  +    '</span>';
                }
                $('#text3').html( newText );


                newText = '';
                for( character in text){
                    newText +=  '<span class="letter">' +( murcielago[ text[character] ] ? murcielago[ text[character] ] : text[character]) +    '</span>';
                }
                $('#text4').html( newText );

                newText = '';
                for( character in text){
                    newText +=  '<span class="letter">' +( cenitPolar[ text[character] ] ? cenitPolar[ text[character] ] : text[character] )+    '</span>';
                }
                $('#text5').html( newText );

            }
        );
        </script>
        <style type="text/css">

            span.letter {
                font-family: monospace ;
                font-size  : 20px ;
                display: inline-block ; 

                height : 20px ;
                min-width: 20px ;
                font-weight: bold ;
            }
        </style>
    </body>
</html>
