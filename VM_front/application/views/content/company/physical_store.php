<main id="main">
    <div class="page_banner">
        <img src="images/banner_company.jpg">
    </div>
    <div class="company_block page_block">
        <div class="block_inner">
            <h1 class="block_title">About Our Physical Stores</h1>
            <div class="block_main">
                <div class="words">
                    <?= nl2br($company->store) ?>
                </div>
                <?php if($storeList){
                    foreach($storeList as $storeKey => $storeValue){ ?>
                        <div class="physical_stores">
                            <div class="map">
                                <iframe src="<?= $storeValue->map_url ?>" width="100%" height="220" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                            </div>
                            <div class="physical_info">
                                <h2 class="block_subtitle"><?= $storeValue->title ?></h2>
                                <div class="info_items">
                                    <div class="item">
                                        <i class="icon_map_marker2"></i>
                                        <a href="<?= $storeValue->address_url ?>" target="_blank"><?= $storeValue->address ?></a>
                                    </div>
                                    <div class="item">
                                        <i class="icon_phone"></i>
                                        <a href="tel:<?= $storeValue->phone ?>"><?= $storeValue->phone ?></a>
                                    </div>
                                    <div class="item">
                                        <i class="icon_clock"></i><span><?= $storeValue->time ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                } ?>               
            </div>
        </div>
    </div>
</main>