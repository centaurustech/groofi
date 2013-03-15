<?php /* @var $this ViewCC */ ?>
<?
$this->set('title_for_layout', Offer::getName($offer));
$this->set('pageTitle', Offer::getName($offer));
$this->set('pageSubTitle', sprintf(__('OFFER_BY %s IN CATEGORY %s', true)
                , $this->Html->tag('span', User::getName($offer), array('class' => 'highlight user-name', 'url' => User::getLink($offer)))
                , $this->Html->tag('span', Category::getName($offer), array('class' => 'highlight category-name', 'url' => Category::getLink($offer, 'projects')))
        )
);
?>





<ul class="pageElement tabs">

    <?
    echo $this->Html->tag('li', $this->Html->link(__('THE_OFFER', true), Offer::getLink($offer)), array('class' => 'tab-offers'));
    if (Offer::isPublic($offer)) {
        if ($offer['Offer']['comment_count'] > 0) {
            echo $this->Html->tag('li', $this->Html->link(__('COMMENTS', true), Offer::getLink($offer, 'comments')), array('class' => 'tab-comments'));
        } else {
            echo $this->Html->tag('li', $this->Html->link(sprintf(__('COMMENTS %s', true), $offer['Offer']['comment_count']), Offer::getLink($offer, 'comments')), array('class' => 'tab-comments'));
        }

        if ($offer['Offer']['post_count'] > 0) {
            echo $this->Html->tag('li', $this->Html->link(sprintf(__('UPDATES %s', true), $offer['Offer']['post_count']), Offer::getLink($offer, 'updates')), array('class' => 'tab-posts'));
        }

        if ($offer['Offer']['project_count'] > 0) {
            echo $this->Html->tag('li', $this->Html->link(sprintf(__('RELATED_PROJECTS %s', true), $offer['Offer']['project_count']), Offer::getLink($offer, 'projects')), array('class' => 'tab-projects'));
        }

        if (Offer::isOwnOffer($offer)) {

            echo $this->Html->tag('li', $this->Html->link(__('CREATE_UPDATE', true), Offer::getLink($offer, 'create-update')), array('class' => 'action'));
        }
    } else {
        if (Offer::isOwnOffer($offer)) {
            echo $this->Html->tag('li', $this->Html->link(__('EDIT_THIS_OFFER', true), Offer::getLink($offer, 'edit')), array('class' => 'action'));
            echo $this->Html->tag('li', $this->Html->link(__('PUBLISH_THIS_OFFER', true), Offer::getLink($offer, 'publish_2')), array('class' => 'action'));
        }
    }
    ?>



</ul>


<cake:script>
    <script type="text/javascript">
        $('.tab-<?= low($this->params['controller']) ?>').addClass('active');
        
        $('a.confirm').click(function(){
            publishOffer(function() {
                window.location = '<?= Offer::getLink($offer, 'publish_2') ?>' ;
            });
            return false ;
        });        
    </script>
</cake:script>

