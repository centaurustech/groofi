    <?
    ?>

    <div style="width:560px;float: left;" class="main-info">

        <h2> <?= sprintf(__('OFFER %s FROM %s IN THE CATEGORY %s', true), Offer::getName($offer), User::getName($offer), Category::getName($offer)); ?> </h2>

        <h3><? __('SHORT_DESCRIPTION') ?></h3>
        <p class="short-description">
            <?php echo $offer['Offer']['short_description']; ?>
        </p>  
        


        <div class="full-description post"> 
            <h3><? __('OFFER_MAIN_POST') ?></h3>
            <?php echo $offer['Offer']['description']; ?> 
        </div>

    </div>
    
    
    <? if ($offer['Offer']['status'] == OFFER_STATUS_NEW ) { ?>
    <div  style="width:380px;float: right;" class="actions">
        <a class="auto-process confirm reload" href="/admin/offers/approve/<?=$offer['Offer']['id']?>"><?__('APPROVE_PROPOSAL')?></a>
        <a class="auto-process confirm reload" href="/admin/offers/reject/<?=$offer['Offer']['id']?>"><?__('REJECT_PROPOSAL')?></a>
        <!-- <a href="/admin/offers/approve/<?=$offer['Offer']['id']?>"><?__('DELETE_PROPOSAL')?></a> 
        <a href="/admin/offers/approve/<?=$offer['Offer']['id']?>"><?__('UNPUBLISH_PROPOSAL')?></a>
        -->
    </div>
    <? } ?>
    
    <div  style="width:380px;float: right;" class="extra-info">
        
        <div class="">

            <?
            
            
            
            if ($video =  getVideoEmbed($offer['Offer']['video_url'] ,  340 , 262 )) {
                
                ?><h3><? __('OFFER_VIDEO') ?></h3><?
            echo $this->Html->div('offer-video',$video);
            
        }
            ?><h3><? __('OFFER_IMAGE') ?></h3><?
            $file = $this->Media->file('l280/' . $offer['Offer']['image_file']);
            $image = $this->Media->embed($file);
            echo $this->Html->div('offer-image', ( $image ? $image : $this->Html->image('/img/assets/img_default_280x210px.png')));
            ?>

        </div>
        



        <ul class="status-info">



            <?
            switch ($offer['Offer']['status']) {
                case OFFER_STATUS_NEW :
                    $status = __('PROPOSAL_OFFER_STATUS', true);
                    break;
                case OFFER_STATUS_APROVED :
                    $status = __('APPROVED_OFFER_STATUS', true);
                    break;
                case OFFER_STATUS_REJECTED :
                    $status = __('REJECTED_OFFER_STATUS', true);
                    break;
                case OFFER_STATUS_PUBLISHED :
                    $status = __('PUBLISHED_OFFER_STATUS', true);
                    break;
                default :
                    $status = __('UNKNOWN_OFFER_STATUS', true);
                    break;
            }
            ?>
            <li class="status_<?= $offer['Offer']['status'] ?>" ><b><? __('OFFER_STATUS') ?></b><span><?= $status ?></span></li>

            <li><b><? __('OFFER_DURATION') ?></b><?php echo $offer['Offer']['offer_duration']; ?></li>
            <li><b><? __('OFFER_CREATED') ?></b><? echo $this->Time->format($offer['Offer']['created'], '%A %d  ' . __('OF', true) . ' %B ' . __('OF', true) . ' %Y'); ?></li>

            <? if ($offer['Offer']['public'] == 1) { ?>
                <li><b><? __('OFFER_PUBLISH_DATE') ?></b><?php echo $offer['Offer']['publish_date']; ?></li>
                
       

                <li><b><? __('OFFER_UPDATES') ?></b><?php echo $offer['Offer']['post_count']; ?></li>
                <li><b><? __('OFFER_COMMENTS') ?></b><?php echo $offer['Offer']['comment_count']; ?></li>
                <li><b><? __('OFFER_FOLLOWS') ?></b><?php echo $offer['Offer']['follow_count']; ?></li>
                <li><b><? __('OFFER_PROJECTS') ?></b><?php echo $offer['Offer']['project_count']; ?></li>
            <? } ?> 


        </ul>






            <?php if (!empty($offer['Link'])): ?>
        <div class="related">
            <h3><?php __('Related Links'); ?></h3>
                <ul>
                    <?php
                    $i = 0;
                    foreach ($offer['Link'] as $link):
                        ?>
                        <li>  
                            <?php echo $this->Html->link($link['link'], $link['link'], array('target' => '_BLANK')); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
        </div>
            <?php endif; ?>



            <?php if (!empty($offer['Prize'])): ?>
        <div class="related">
            <h3><?php __('Related Prizes'); ?></h3>
                <ul>
                    <?php
                    foreach ($offer['Prize'] as $prize):
                        ?>
                        <li>
                            <span class="value"><?php echo $prize['value']; ?></span>
                            <span class="prize"><?php echo $prize['description']; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
        </div>
            <?php endif; ?>
   

 