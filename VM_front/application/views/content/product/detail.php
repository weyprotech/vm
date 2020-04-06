<main id="main">
    <div class="breadcrumbs pb_none">
        <div class="breadcrumbs_inner">
            <a href="<?= website_url('product/index').'?baseId='.$base_category->categoryId ?>"><?= $base_category->name ?></a><span>/</span>
            <a href="<?= website_url('product/index').'?subId='.$sub_category->categoryId ?>"><?= $sub_category->name ?></a><span>/</span>
            <a href="<?= website_url('product/index').'?categoryId='.$category->categoryId ?>"><?= $category->name ?></a><span>/</span>
        </div>
    </div>
    <div class="product_showcase page_block">
        <div class="block_inner">
            <div class="showcase_slider_wrapper">
                <div class="showcase_nav">
                    <?php if($product_banner){
                        foreach($product_banner as $bannerKey => $bannerValue){ ?>
                            <div class="slide">
                                <div class="thumb">
                                    <div class="pic" style="background-image: url(<?= backend_url($bannerValue->thumbPath) ?>)">
                                        <img class="size" src="<?= base_url('assets/images/size_3x4.png') ?>">
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>                    
                </div>
                <div class="showcase_slider">
                    <div class="slide">
                        <a class="thumb popup" href="popup_products.html" data-index="0">
                            <div class="pic" style="background-image: url(images/img_product01_showcase.jpg)">
                                <img class="size" src="images/size_3x4.png">
                            </div>
                        </a>
                    </div>
                    <div class="slide"><a class="thumb popup" href="popup_products.html" data-index="1">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/470x627)"><img class="size" src="images/size_3x4.png"></div></a></div>
                    <div class="slide"><a class="thumb is_video popup" href="popup_products.html" data-index="2">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/470x627)"><img class="size" src="images/size_3x4.png"></div></a></div>
                    <div class="slide"><a class="thumb popup" href="popup_products.html" data-index="3">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/470x627)"><img class="size" src="images/size_3x4.png"></div></a></div>
                    <div class="slide"><a class="thumb is_video popup" href="popup_products.html" data-index="4">
                        <div class="pic" style="background-image: url(https://via.placeholder.com/470x627)"><img class="size" src="images/size_3x4.png"></div></a></div>
                </div>
                <div class="share_links">Share
                    <a class="facebook" href="javascript:;" target="_blank"><i class="icon_share_facebook"></i></a>
                    <a class="pinterest" href="javascript:;" target="_blank"><i class="icon_share_pinterest"></i></a>
                </div>
            </div>
            <div class="showcase_content">
                <h1 class="product_title">PRINTED MINI DRESS</h1>
                <div class="product_intro">Printed silk dress with aquatic flower motif</div>
                <div class="product_price">
                    $2,880
                    <!--↓ 如果是Sale 使用這個 ↓-->
                    <!--
                    <span class="strikethrough">$2,880</span>
                    <span class="sale_price">$1,990</span>
                    -->
                    <!--↑ 如果是Sale 使用這個 ↑-->
                </div>
                <div class="products_sku">
                    <div class="controls_group">
                        <label>Size</label>
                        <div class="controls">
                            <div class="select_wrapper">
                                <select>
                                <option>S</option>
                                <option>M</option>
                                <option>L</option>
                                </select>
                            </div>
                            <div class="note">(size guide)</div>
                        </div>
                    </div>
                    <div class="controls_group">
                        <label>Color</label>
                        <div class="controls">
                        <div class="select_wrapper">
                            <select>
                            <option>Select a color</option>
                            <option>Blue</option>
                            <option>Red</option>
                            </select>
                        </div>
                        </div>
                    </div>
                    <div class="controls_group">
                        <label>Quantity</label>
                        <div class="controls">
                        <div class="quantity_counter">
                            <button class="minus" type="button">&minus;</button>
                            <input class="quantity" type="number" value="1" min="1" readOnly="true">
                            <button class="plus" type="button">&plus;</button>
                        </div>
                        </div>
                    </div>
                    <div class="call_action">
                        <button class="btn confirm" type="button">Add to cart</button>
                        <!--↓ 如果是預購改用這個 button ↓-->
                        <!-- <button class="btn" type="button">Preorder Now</button>-->
                        <!--↑ 如果是預購改用這個 button ↑-->
                        <!--↓ class 加 'active' 表示加入最愛 ↓--><a class="btn_favorite" href="javascript:;" data-productId="product001" title="Favorite"><i class="icon_favorite_heart"></i></a>
                        <!--↑ class 加 'active' 表示加入最愛 ↑-->
                    </div>
                </div>
                <div class="products_fold fold_block">
                    <div class="fold">
                        <div class="fold_title active">Product Details</div>
                        <div class="fold_content active">
                            <ul>
                                <li>As seen in the Spring Summer '20 lookbook, pair with white strappy sandals to complete the look</li>
                                <li>Ruffled hem, puffed sleeves, mini length, lined</li>
                                <li>Zipper fastening and hook &amp; eye closure</li>
                                <li>Composition: 100% rayon light</li>
                                <li>Hand-wash &amp; rinse in cold water, dry flat or tumble dry, do not bleach or dry clean</li>
                            </ul>
                        </div>
                    </div>
                    <div class="fold">
                        <div class="fold_title">Shipping &nbsp; Returns</div>
                        <div class="fold_content">Returnable within 14 days of delivery date. Return Policy<br>Free shipping available worldwide. Check our shipping policy to see your countries minimum order requirement. Shipping Policy.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product_detail_reviews page_block">
        <div class="block_inner">
        <div class="tabber_wrapper">
            <div class="tabber-selectors">
                <div class="sort_menu">
                    <ul>
                        <li><a class="tabber-anchor active" href="javascript:;">Product Detail</a></li>
                        <li><a class="tabber-anchor" href="javascript:;">Reviews</a></li>
                    </ul>
                </div>
            </div>
            <div class="tabber-contents">
                <div class="tabber-content active">
                    <div class="product_detail"><img src="images/img_product_detail.jpg"></div>
                </div>
                <div class="tabber-content">
                    <div class="product_reviews">
                        <div class="reviews_title">
                            <span class="score">4.8</span>
                            <div class="rate_star" data-rateyo-read-only="true" data-rateyo-star-width="24px" data-rateyo-rating="4.5"></div><span class="count">(32 Reviews)</span>
                        </div>
                        <div class="reviews_wrapper">
                            <div class="item">
                                <div class="review">
                                    <div class="review_content">
                                        <div class="user_info">
                                            <div class="profile_picture">
                                                <div class="pic" style="background-image: url(https://source.unsplash.com/JQDflNNnrEE/100x100);">
                                                    <img class="size" src="images/size_1x1.png">
                                                </div>
                                            </div>
                                            <div class="title">
                                                <div class="name">Lily Allen</div>
                                            </div>
                                        </div>
                                        <div class="purchase_info">Size: <span>L</span> &nbsp; &nbsp; &nbsp;Color: <span>White</span></div>
                                        <div class="rate_date">
                                            <div class="rate_star" data-rateyo-read-only="true" data-rateyo-rating="5"></div>
                                            <div class="date">2019.08.01</div>
                                        </div>
                                        <div class="text">Nice! Comfort!</div>
                                    </div>
                                </div>
                                <div class="review reply">
                                    <div class="review_content">
                                        <div class="user_info">
                                            <div class="profile_picture">
                                                <div class="pic" style="background-image: url(images/img_profile.jpg);">
                                                    <img class="size" src="images/size_1x1.png">
                                                </div>
                                            </div>
                                            <div class="title">
                                            <div class="name">Lily Allen</div>
                                            <div class="divide_line"></div><span>Reply</span>
                                            <div class="divide_line"></div><span>2019.08.01</span>
                                            </div>
                                        </div>
                                        <div class="text">Thank you ：）</div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                            <div class="review">
                                <div class="review_content">
                                <div class="user_info">
                                    <div class="profile_picture">
                                    <div class="pic" style="background-image: url(https://source.unsplash.com/6W4F62sN_yI/100x100);"><img class="size" src="images/size_1x1.png"></div>
                                    </div>
                                    <div class="title">
                                    <div class="name">Ann Li</div>
                                    </div>
                                </div>
                                <div class="purchase_info">Size: <span>M</span> &nbsp; &nbsp; &nbsp;Color: <span>Black</span></div>
                                <div class="rate_date">
                                    <div class="rate_star" data-rateyo-read-only="true" data-rateyo-rating="4.5"></div>
                                    <div class="date">2019.08.01</div>
                                </div>
                                <div class="text">I am really pleased with this dress, I am 5' 1" and usually size 10, but size 8 fitted me well and the length is just fine on me and not too long. It could be worn as a summer dress to the office, or dressed up with heels for a smart evening out or afternoon tea. Lovely vibrant colours and nice flowing material. Very pleased - another great dress from Matalan at a very reasonable price.</div>
                                </div>
                            </div>
                            </div>
                            <div class="item">
                            <div class="review">
                                <div class="review_content">
                                <div class="user_info">
                                    <div class="profile_picture">
                                    <div class="pic" style="background-image: url(https://source.unsplash.com/JQDflNNnrEE/100x100);"><img class="size" src="images/size_1x1.png"></div>
                                    </div>
                                    <div class="title">
                                    <div class="name">Lily Allen</div>
                                    </div>
                                </div>
                                <div class="purchase_info">Size: <span>L</span> &nbsp; &nbsp; &nbsp;Color: <span>White</span></div>
                                <div class="rate_date">
                                    <div class="rate_star" data-rateyo-read-only="true" data-rateyo-rating="5"></div>
                                    <div class="date">2019.08.01</div>
                                </div>
                                <div class="text">Nice! Comfort!</div>
                                </div>
                            </div>
                            <div class="review reply">
                                <div class="review_content">
                                <div class="user_info">
                                    <div class="profile_picture">
                                    <div class="pic" style="background-image: url(images/img_profile.jpg);"><img class="size" src="images/size_1x1.png"></div>
                                    </div>
                                    <div class="title">
                                    <div class="name">Lily Allen</div>
                                    <div class="divide_line"></div><span>Reply</span>
                                    <div class="divide_line"></div><span>2019.08.01</span>
                                    </div>
                                </div>
                                <div class="text">Thank you ：）</div>
                                </div>
                            </div>
                            </div>
                            <div class="item">
                            <div class="review">
                                <div class="review_content">
                                <div class="user_info">
                                    <div class="profile_picture">
                                    <div class="pic" style="background-image: url(https://source.unsplash.com/6W4F62sN_yI/100x100);"><img class="size" src="images/size_1x1.png"></div>
                                    </div>
                                    <div class="title">
                                    <div class="name">Ann Li</div>
                                    </div>
                                </div>
                                <div class="purchase_info">Size: <span>M</span> &nbsp; &nbsp; &nbsp;Color: <span>Black</span></div>
                                <div class="rate_date">
                                    <div class="rate_star" data-rateyo-read-only="true" data-rateyo-rating="4.5"></div>
                                    <div class="date">2019.08.01</div>
                                </div>
                                <div class="text">I am really pleased with this dress, I am 5' 1" and usually size 10, but size 8 fitted me well and the length is just fine on me and not too long. It could be worn as a summer dress to the office, or dressed up with heels for a smart evening out or afternoon tea. Lovely vibrant colours and nice flowing material. Very pleased - another great dress from Matalan at a very reasonable price.</div>
                                </div>
                            </div>
                            </div>
                            <div class="item">
                            <div class="review">
                                <div class="review_content">
                                <div class="user_info">
                                    <div class="profile_picture">
                                    <div class="pic" style="background-image: url(https://source.unsplash.com/JQDflNNnrEE/100x100);"><img class="size" src="images/size_1x1.png"></div>
                                    </div>
                                    <div class="title">
                                    <div class="name">Lily Allen</div>
                                    </div>
                                </div>
                                <div class="purchase_info">Size: <span>L</span> &nbsp; &nbsp; &nbsp;Color: <span>White</span></div>
                                <div class="rate_date">
                                    <div class="rate_star" data-rateyo-read-only="true" data-rateyo-rating="5"></div>
                                    <div class="date">2019.08.01</div>
                                </div>
                                <div class="text">Nice! Comfort!</div>
                                </div>
                            </div>
                            <div class="review reply">
                                <div class="review_content">
                                <div class="user_info">
                                    <div class="profile_picture">
                                    <div class="pic" style="background-image: url(images/img_profile.jpg);"><img class="size" src="images/size_1x1.png"></div>
                                    </div>
                                    <div class="title">
                                    <div class="name">Lily Allen</div>
                                    <div class="divide_line"></div><span>Reply</span>
                                    <div class="divide_line"></div><span>2019.08.01</span>
                                    </div>
                                </div>
                                <div class="text">Thank you ：）</div>
                                </div>
                            </div>
                            </div>
                            <div class="item">
                            <div class="review">
                                <div class="review_content">
                                <div class="user_info">
                                    <div class="profile_picture">
                                    <div class="pic" style="background-image: url(https://source.unsplash.com/6W4F62sN_yI/100x100);"><img class="size" src="images/size_1x1.png"></div>
                                    </div>
                                    <div class="title">
                                    <div class="name">Ann Li</div>
                                    </div>
                                </div>
                                <div class="purchase_info">Size: <span>M</span> &nbsp; &nbsp; &nbsp;Color: <span>Black</span></div>
                                <div class="rate_date">
                                    <div class="rate_star" data-rateyo-read-only="true" data-rateyo-rating="4.5"></div>
                                    <div class="date">2019.08.01</div>
                                </div>
                                <div class="text">I am really pleased with this dress, I am 5' 1" and usually size 10, but size 8 fitted me well and the length is just fine on me and not too long. It could be worn as a summer dress to the office, or dressed up with heels for a smart evening out or afternoon tea. Lovely vibrant colours and nice flowing material. Very pleased - another great dress from Matalan at a very reasonable price.</div>
                                </div>
                            </div>
                            </div>
                            <div class="item">
                            <div class="review">
                                <div class="review_content">
                                <div class="user_info">
                                    <div class="profile_picture">
                                    <div class="pic" style="background-image: url(https://source.unsplash.com/JQDflNNnrEE/100x100);"><img class="size" src="images/size_1x1.png"></div>
                                    </div>
                                    <div class="title">
                                    <div class="name">Lily Allen</div>
                                    </div>
                                </div>
                                <div class="purchase_info">Size: <span>L</span> &nbsp; &nbsp; &nbsp;Color: <span>White</span></div>
                                <div class="rate_date">
                                    <div class="rate_star" data-rateyo-read-only="true" data-rateyo-rating="5"></div>
                                    <div class="date">2019.08.01</div>
                                </div>
                                <div class="text">Nice! Comfort!</div>
                                </div>
                            </div>
                            <div class="review reply">
                                <div class="review_content">
                                <div class="user_info">
                                    <div class="profile_picture">
                                    <div class="pic" style="background-image: url(images/img_profile.jpg);"><img class="size" src="images/size_1x1.png"></div>
                                    </div>
                                    <div class="title">
                                    <div class="name">Lily Allen</div>
                                    <div class="divide_line"></div><span>Reply</span>
                                    <div class="divide_line"></div><span>2019.08.01</span>
                                    </div>
                                </div>
                                <div class="text">Thank you ：）</div>
                                </div>
                            </div>
                            </div>
                            <div class="item">
                            <div class="review">
                                <div class="review_content">
                                <div class="user_info">
                                    <div class="profile_picture">
                                    <div class="pic" style="background-image: url(https://source.unsplash.com/6W4F62sN_yI/100x100);"><img class="size" src="images/size_1x1.png"></div>
                                    </div>
                                    <div class="title">
                                    <div class="name">Ann Li</div>
                                    </div>
                                </div>
                                <div class="purchase_info">Size: <span>M</span> &nbsp; &nbsp; &nbsp;Color: <span>Black</span></div>
                                <div class="rate_date">
                                    <div class="rate_star" data-rateyo-read-only="true" data-rateyo-rating="4.5"></div>
                                    <div class="date">2019.08.01</div>
                                </div>
                                <div class="text">I am really pleased with this dress, I am 5' 1" and usually size 10, but size 8 fitted me well and the length is just fine on me and not too long. It could be worn as a summer dress to the office, or dressed up with heels for a smart evening out or afternoon tea. Lovely vibrant colours and nice flowing material. Very pleased - another great dress from Matalan at a very reasonable price.</div>
                                </div>
                            </div>
                            </div>
                            <div class="item">
                            <div class="review">
                                <div class="review_content">
                                <div class="user_info">
                                    <div class="profile_picture">
                                    <div class="pic" style="background-image: url(https://source.unsplash.com/JQDflNNnrEE/100x100);"><img class="size" src="images/size_1x1.png"></div>
                                    </div>
                                    <div class="title">
                                    <div class="name">Lily Allen</div>
                                    </div>
                                </div>
                                <div class="purchase_info">Size: <span>L</span> &nbsp; &nbsp; &nbsp;Color: <span>White</span></div>
                                <div class="rate_date">
                                    <div class="rate_star" data-rateyo-read-only="true" data-rateyo-rating="5"></div>
                                    <div class="date">2019.08.01</div>
                                </div>
                                <div class="text">Nice! Comfort!</div>
                                </div>
                            </div>
                            <div class="review reply">
                                <div class="review_content">
                                <div class="user_info">
                                    <div class="profile_picture">
                                    <div class="pic" style="background-image: url(images/img_profile.jpg);"><img class="size" src="images/size_1x1.png"></div>
                                    </div>
                                    <div class="title">
                                    <div class="name">Lily Allen</div>
                                    <div class="divide_line"></div><span>Reply</span>
                                    <div class="divide_line"></div><span>2019.08.01</span>
                                    </div>
                                </div>
                                <div class="text">Thank you ：）</div>
                                </div>
                            </div>
                            </div>
                            <div class="item">
                            <div class="review">
                                <div class="review_content">
                                <div class="user_info">
                                    <div class="profile_picture">
                                    <div class="pic" style="background-image: url(https://source.unsplash.com/6W4F62sN_yI/100x100);"><img class="size" src="images/size_1x1.png"></div>
                                    </div>
                                    <div class="title">
                                    <div class="name">Ann Li</div>
                                    </div>
                                </div>
                                <div class="purchase_info">Size: <span>M</span> &nbsp; &nbsp; &nbsp;Color: <span>Black</span></div>
                                <div class="rate_date">
                                    <div class="rate_star" data-rateyo-read-only="true" data-rateyo-rating="4.5"></div>
                                    <div class="date">2019.08.01</div>
                                </div>
                                <div class="text">I am really pleased with this dress, I am 5' 1" and usually size 10, but size 8 fitted me well and the length is just fine on me and not too long. It could be worn as a summer dress to the office, or dressed up with heels for a smart evening out or afternoon tea. Lovely vibrant colours and nice flowing material. Very pleased - another great dress from Matalan at a very reasonable price.</div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="pager_bar">
                            <div class="pages">Page 1 of 15</div>
                            <ul class="pager_navigation">
                            <li class="prev"><a href="javascript:;">&lt; Previous</a></li>
                            <li class="current"><a href="javascript:;">1</a></li>
                            <li><a href="javascript:;">2</a></li>
                            <li><a href="javascript:;">3</a></li>
                            <li><a href="javascript:;">4</a></li>
                            <li><a href="javascript:;">5</a></li>
                            <li class="next"><a href="javascript:;">Next &gt;</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="product_about">
        <div class="designer_banner banner_slider">
        <div class="slide"><img src="images/banner_designer.jpg" alt=""></div>
        <div class="slide"><img src="https://via.placeholder.com/1920x826" alt=""></div>
        <div class="slide"><img src="https://via.placeholder.com/1920x826" alt=""></div>
        </div>
        <div class="tabber_wrapper">
        <div class="tabber-selectors">
            <div class="sort_menu">
            <ul>
                <li><a class="tabber-anchor active" href="javascript:;">About Designer</a></li>
                <li><a class="tabber-anchor" href="javascript:;">Manufacture</a></li>
                <li><a class="tabber-anchor" href="javascript:;">Fabric</a></li>
            </ul>
            </div>
        </div>
        <div class="tabber-contents">
            <div class="tabber-content active">
            <div class="product_about_designer">
                <div class="designer_introduction">
                <div class="intro_content">
                    <div class="designer_info"><a href="designer_profile.html">
                        <div class="profile_picture">
                        <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                        <div class="pic" style="background-image: url(images/img_profile.jpg"><img class="size" src="images/size_1x1.png"></div>
                        <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                        </div>
                        <div class="text">
                        <div class="designer_name">
                            <!--↓ 知名設計才會有鑽石icon ↓--><i class="icon_diamond_b"></i>
                            <!--↑ 知名設計才會有鑽石icon ↑--><span>Douglas Robinson</span>
                        </div>
                        </div></a></div>
                    <div class="intro_text">
                    <p>Retro occupy organic, stumptown shabby chic pour-over roof party DIY normcore. Actually artisan organic occupy, Wes Anderson ugh whatever pour-over gastropub selvage. Chillwave craft beer tote bag stumptown quinoa hashtag. Dreamcatcher locavore iPhone chillwave, occupy trust fund slow-carb distillery art party narwhal.</p>
                    </div><a class="btn common" href="designer_home.html">view more</a>
                    <hr>
                    <h2 class="subtitle">Brand Name</h2>
                    <div class="intro_text">
                    <p>Retro occupy organic, stumptown shabby chic pour-over roof party DIY normcore. Actually artisan organic occupy, Wes Anderson ugh whatever pour-over gastropub selvage. Chillwave craft beer tote bag stumptown quinoa hashtag. Dreamcatcher locavore iPhone chillwave, occupy trust fund slow-carb distillery art party narwhal.</p>
                    </div><a class="btn common" href="brand_story.html">brand story</a>
                </div>
                <div class="intro_image">
                    <div class="thumb">
                    <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                    <div class="pic" style="background-image: url(images/img_designer.jpg);"><img class="size" src="images/size_3x4.png"></div>
                    <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                    </div>
                </div>
                </div>
                <div class="latest_post">
                <h2 class="subtitle">Latest Post</h2>
                <div class="post_block_wrapper">
                    <div class="post_block">
                    <div class="post_main">
                        <div class="post_content">
                        <h3 class="post_title">The Best Street Style From Copenhagen Fashion Week</h3>
                        <time class="date">2019.09.09 23:48</time>
                        <div class="text">Following the cancellation of Stockholm Fashion Week’s latest season, to allow the Swedish Fashion Council to find more sustainable alternatives, all eyes have been on its Danish neighbour.</div>
                        </div>
                        <div class="post_media"><a class="thumb popup" href="popup_media.html">
                            <div class="pic" style="background-image: url(https://source.unsplash.com/TS--uNw-JqE/400x225);"><img class="size" src="images/size_16x9.png"></div></a></div>
                    </div>
                    <div class="comments_block">
                        <div class="comments_title"><i class="icon_msg"></i>
                        <h2>2 comments</h2><i class="arrow_down"></i>
                        </div>
                        <div class="comments_content">
                        <div class="comments_form">
                            <div class="profile_picture">
                            <div class="pic" style="background-image: url(https://source.unsplash.com/rDEOVtE7vOs/100x100);"><img class="size" src="images/size_1x1.png"></div>
                            </div>
                            <div class="controls">
                            <input type="text" placeholder="Leave us a message...">
                            <button type="button">Send</button>
                            </div>
                        </div>
                        <div class="comments_messages">
                            <div class="item">
                            <div class="msg">
                                <div class="profile_picture">
                                <div class="pic" style="background-image: url(https://source.unsplash.com/JQDflNNnrEE/100x100);"><img class="size" src="images/size_1x1.png"></div>
                                </div>
                                <div class="msg_content">
                                <div class="title">
                                    <div class="name">Lily Allen</div>
                                    <div class="divide_line"></div>
                                    <div class="time">2019.08.01 18:05</div>
                                </div>
                                <div class="text">Donec facilisis tortor ut augue.</div>
                                </div>
                            </div>
                            <div class="msg reply">
                                <div class="profile_picture">
                                <div class="pic" style="background-image: url(images/vm_profile_pic.jpg);"><img class="size" src="images/size_1x1.png"></div>
                                </div>
                                <div class="msg_content">
                                <div class="title">
                                    <div class="name">Reply</div>
                                    <div class="divide_line"></div>
                                    <div class="time">2019.08.01 18:05</div>
                                </div>
                                <div class="text">Cras quis.</div>
                                </div>
                            </div>
                            </div>
                            <div class="item">
                            <div class="msg">
                                <div class="profile_picture">
                                <div class="pic" style="background-image: url(images/img_member_noPic.jpg);"><img class="size" src="images/size_1x1.png"></div>
                                </div>
                                <div class="msg_content">
                                <div class="title">
                                    <div class="name">Annie ELe</div>
                                    <div class="divide_line"></div>
                                    <div class="time">2019.08.01 18:05</div>
                                </div>
                                <div class="text">Keytar McSweeney's Williamsburg,.</div>
                                </div>
                            </div>
                            </div>
                        </div><a class="open_comments" href="javascript:;">See more comments</a>
                        </div>
                    </div>
                    </div>
                    <div class="post_block">
                    <div class="post_main">
                        <div class="post_content">
                        <h3 class="post_title">A Cotton Dress And Trainers Is The Unofficial Uniform Of Copenhagen Fashion Week</h3>
                        <time class="date">2019.09.09 23:48</time>
                        <div class="text">Following the cancellation of Stockholm Fashion Week’s latest season, to allow the Swedish Fashion Council to find more sustainable alternatives, all eyes have been on its Danish neighbour.</div>
                        </div>
                    </div>
                    <div class="comments_block">
                        <div class="comments_title"><i class="icon_msg"></i>
                        <h2>comments</h2><i class="arrow_down"></i>
                        </div>
                        <div class="comments_content">
                        <div class="comments_form">
                            <div class="profile_picture">
                            <div class="pic" style="background-image: url(https://source.unsplash.com/rDEOVtE7vOs/100x100);"><img class="size" src="images/size_1x1.png"></div>
                            </div>
                            <div class="controls">
                            <input type="text" placeholder="Leave us a message...">
                            <button type="button">Send</button>
                            </div>
                        </div>
                        <div class="comments_messages">
                            <!-- 沒有留言-->
                        </div>
                        <!--↓ 沒有留言不顯示 ↓-->
                        <!--<a class="open_comments" href="javascript:;">See more comments</a>
                        -->
                        <!--↑ 沒有留言不顯示 ↑-->
                        </div>
                    </div>
                    </div>
                    <div class="post_block">
                    <div class="post_main">
                        <div class="post_content">
                        <h3 class="post_title">The Best Street Style From Copenhagen Fashion Week</h3>
                        <time class="date">2019.09.09 23:48</time>
                        <div class="text">Following the cancellation of Stockholm Fashion Week’s latest season, to allow the Swedish Fashion Council to find more sustainable alternatives, all eyes have been on its Danish neighbour.</div>
                        </div>
                        <div class="post_media"><a class="thumb has_more popup" href="popup_media.html">
                            <div class="pic" style="background-image: url(https://source.unsplash.com/P3pI6xzovu0/400x225);"><img class="size" src="images/size_16x9.png"></div>
                            <div class="btn common">More +</div></a></div>
                    </div>
                    <div class="comments_block">
                        <div class="comments_title"><i class="icon_msg"></i>
                        <h2>2 comments</h2><i class="arrow_down"></i>
                        </div>
                        <div class="comments_content">
                        <div class="comments_form">
                            <div class="profile_picture">
                            <div class="pic" style="background-image: url(https://source.unsplash.com/rDEOVtE7vOs/100x100);"><img class="size" src="images/size_1x1.png"></div>
                            </div>
                            <div class="controls">
                            <input type="text" placeholder="Leave us a message...">
                            <button type="button">Send</button>
                            </div>
                        </div>
                        <div class="comments_messages">
                            <div class="item">
                            <div class="msg">
                                <div class="profile_picture">
                                <div class="pic" style="background-image: url(https://source.unsplash.com/JQDflNNnrEE/100x100);"><img class="size" src="images/size_1x1.png"></div>
                                </div>
                                <div class="msg_content">
                                <div class="title">
                                    <div class="name">Lily Allen</div>
                                    <div class="divide_line"></div>
                                    <div class="time">2019.08.01 18:05</div>
                                </div>
                                <div class="text">Donec facilisis tortor ut augue.</div>
                                </div>
                            </div>
                            <div class="msg reply">
                                <div class="profile_picture">
                                <div class="pic" style="background-image: url(images/vm_profile_pic.jpg);"><img class="size" src="images/size_1x1.png"></div>
                                </div>
                                <div class="msg_content">
                                <div class="title">
                                    <div class="name">Reply</div>
                                    <div class="divide_line"></div>
                                    <div class="time">2019.08.01 18:05</div>
                                </div>
                                <div class="text">Cras quis.</div>
                                </div>
                            </div>
                            </div>
                            <div class="item">
                            <div class="msg">
                                <div class="profile_picture">
                                <div class="pic" style="background-image: url(images/img_member_noPic.jpg);"><img class="size" src="images/size_1x1.png"></div>
                                </div>
                                <div class="msg_content">
                                <div class="title">
                                    <div class="name">Annie ELe</div>
                                    <div class="divide_line"></div>
                                    <div class="time">2019.08.01 18:05</div>
                                </div>
                                <div class="text">Keytar McSweeney's Williamsburg,.</div>
                                </div>
                            </div>
                            </div>
                        </div><a class="open_comments" href="javascript:;">See more comments</a>
                        </div>
                    </div>
                    </div>
                </div><a class="btn common more" href="designer_home.html#posts">view more</a>
                </div>
            </div>
            </div>
            <div class="tabber-content">
            <div class="product_about_cooperate">
                <h2 class="title">HANGZHOU SUNBRIGHT FINISHINGS, LTD.</h2>
                <div class="banner"><img src="https://source.unsplash.com/tabzu_kbVs0/1920x582"></div>
                <div class="cooperate_block">
                <div class="block_inner">
                    <div class="cooperate_introduction">
                    <div class="intro_block">
                        <div class="intro_image">
                        <div class="thumb">
                            <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                            <div class="pic" style="background-image: url(https://source.unsplash.com/tNCH0sKSZbA/540x720);"><img class="size" src="images/size_3x4.png"></div>
                            <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                        </div>
                        </div>
                        <div class="intro_content">
                        <div class="intro_head">
                            <div class="thumb">
                            <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                            <div class="pic" style="background-image: url(https://source.unsplash.com/b1Hg7QI-zcc/100x100);"><img class="size" src="images/size_1x1.png"></div>
                            <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                            </div>
                            <div class="location"><i class="icon_map_marker"></i><span>Hangzhou, China</span></div>
                        </div>
                        <h3 class="subtitle">Just like the women we create for, we're a work-in-progress, but one hell of a piece of art.</h3>
                        <div class="text">HANGZHOU SUNBRIGHT FINISHINGS, LTD. is located in Hangzhou, China, and was established in 2002. We specialize in polyester fabric manufacturing and trading and we mainly offer polyester and poly/spandex knitted fabrics like dazzle, mesh, jersey, PK and tricot. Our products are widely used for garments and home textiles. We produce up to 150,000 kg of fabrics on a monthly basis, covering an area of 7,000 sqm. To meet our customers' requests, we release three to five new items every quarter and showcase our collection by attending both domestic (Shanghai Intertextile Apparel Fabrics Fair) and international (Brazil and Mexico) fabric fairs.</div>
                        </div>
                    </div>
                    <div class="intro_block">
                        <div class="intro_image">
                        <div class="thumb">
                            <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                            <div class="pic" style="background-image: url(https://source.unsplash.com/zMQR294dVTs/540x720);"><img class="size" src="images/size_3x4.png"></div>
                            <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                        </div>
                        </div>
                        <div class="intro_content">
                        <h3 class="subtitle">Just like the women we create for, we're a work-in-progress, but one hell of a piece of art.</h3>
                        <div class="text">HANGZHOU SUNBRIGHT FINISHINGS, LTD. is located in Hangzhou, China, and was established in 2002. We specialize in polyester fabric manufacturing and trading and we mainly offer polyester and poly/spandex knitted fabrics like dazzle, mesh, jersey, PK and tricot. Our products are widely used for garments and home textiles. We produce up to 150,000 kg of fabrics on a monthly basis, covering an area of 7,000 sqm. To meet our customers' requests, we release three to five new items every quarter and showcase our collection by attending both domestic (Shanghai Intertextile Apparel Fabrics Fair) and international (Brazil and Mexico) fabric fairs.</div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="banner"><img src="https://source.unsplash.com/1mnXGDl3iRY/1920x582"></div>
                <div class="cooperate_block">
                <div class="block_inner">
                    <div class="cooperate_brand">
                    <h3 class="subtitle">Brand Story - Title</h3>
                    <div class="text">
                        <p>I think my key issue was this: I didn’t leave myself enough time to plan this wedding. And I’m happy to admit it. If I didn’t have such a hectic career, AND PRIMARILY, if I hadn’t decided to buy a house at the very same time, 9 months would likely have been ample time to plan an at home wedding. But I wanted an abroad wedding… of course I did! *rolls eyes at self numerous times*</p>
                        <p>So giving myself 9 months to find a venue in the South of France was the first hurdle that took longer to climb over than I optimistically expected. And then right after we found the venue, we also found our new house.</p>
                    </div>
                    </div>
                </div>
                </div>
                <div class="cooperate_wall">
                <div class="item"><a class="thumb popup" href="popup_media.html" data-index="0">
                    <!--↓ 16:9，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                    <div class="pic" style="background-image: url(https://source.unsplash.com/vslzoHxSMRo/936x526);"><img class="size" src="images/size_16x9.png"></div>
                    <!--↑ 16:9，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑--></a></div>
                <div class="item"><a class="thumb is_video popup" href="popup_media.html" data-index="1">
                    <!--↓ 16:9，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                    <div class="pic" style="background-image: url(https://source.unsplash.com/R2aodqJn3b8/936x526);"><img class="size" src="images/size_16x9.png"></div>
                    <!--↑ 16:9，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑--></a></div>
                <div class="item"><a class="thumb popup" href="popup_media.html" data-index="2">
                    <!--↓ 16:9，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                    <div class="pic" style="background-image: url(https://source.unsplash.com/BCNjBsK37XA/936x526);"><img class="size" src="images/size_16x9.png"></div>
                    <!--↑ 16:9，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑--></a></div>
                <div class="item cooperate_link">
                    <h3 class="subtitle">Fusce vehicul.</h3><a class="btn common more" href="javascript:;" target="_blank">Find out</a>
                </div>
                </div>
            </div>
            </div>
            <div class="tabber-content">
            <div class="product_about_cooperate">
                <h2 class="title">Wujiang Benmore Textile Imp and Exp Co., Ltd.</h2>
                <div class="banner"><img src="https://via.placeholder.com/1920x582"></div>
                <div class="cooperate_block">
                <div class="block_inner">
                    <div class="cooperate_introduction">
                    <div class="intro_block">
                        <div class="intro_image">
                        <div class="thumb">
                            <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                            <div class="pic" style="background-image: url(https://via.placeholder.com/380x507);"><img class="size" src="images/size_3x4.png"></div>
                            <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                        </div>
                        </div>
                        <div class="intro_content">
                        <div class="intro_head">
                            <div class="thumb">
                            <!--↓ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                            <div class="pic" style="background-image: url(https://via.placeholder.com/100x100);"><img class="size" src="images/size_1x1.png"></div>
                            <!--↑ 1:1，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                            </div>
                            <div class="location"><i class="icon_map_marker"></i><span>Hangzhou, China</span></div>
                        </div>
                        <h3 class="subtitle">Every textile has a story</h3>
                        <div class="text">
                            <p>Wujiang benmore textile imp&amp;exp Co., Ltd. Was established in 2009. It has three main catagories: Polyester fabric, nylon fabric, functional fabrics. Polyester fabric include the polyester taffeta, polyester pongee, polyester oxford, polyester chifffon etc. Nylon fabric in clude the nylon taffeta fabric, nylon oxford fabric, nylon taslon fabric etc. Functional fabric include the waterproof, flame retardant fabric, breathable, anti-UV, anti-bacteria etc.</p>
                            <p>Benmore has the permit of import and export. Currently, its products have been exported to Europe, America, southeast Asia and other countries and regions. The products have been adored by domestic customers as well. The company has been committed to improving the quality of service, puting emphasis on the quality of products and implementing a win-win situation. We sincerely hope that benmore can establish stable commercial relation with more business people.</p>
                        </div>
                        </div>
                    </div>
                    <div class="intro_block">
                        <div class="intro_image">
                        <div class="thumb">
                            <!--↓ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                            <div class="pic" style="background-image: url(https://via.placeholder.com/380x507);"><img class="size" src="images/size_3x4.png"></div>
                            <!--↑ 3:4，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑-->
                        </div>
                        </div>
                        <div class="intro_content">
                        <h3 class="subtitle">Our main products are all kinds of fabrics.</h3>
                        <div class="text">
                            <p>Wujiang benmore textile imp&amp;exp Co., Ltd. Was established in 2009. It has three main catagories: Polyester fabric, nylon fabric, functional fabrics. Polyester fabric include the polyester taffeta, polyester pongee, polyester oxford, polyester chifffon etc. Nylon fabric in clude the nylon taffeta fabric, nylon oxford fabric, nylon taslon fabric etc. Functional fabric include the waterproof, flame retardant fabric, breathable, anti-UV, anti-bacteria etc.</p>
                            <p>Benmore has the permit of import and export. Currently, its products have been exported to Europe, America, southeast Asia and other countries and regions. The products have been adored by domestic customers as well. The company has been committed to improving the quality of service, puting emphasis on the quality of products and implementing a win-win situation. We sincerely hope that benmore can establish stable commercial relation with more business people.</p>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="banner"><img src="https://via.placeholder.com/1920x582"></div>
                <div class="cooperate_block">
                <div class="block_inner">
                    <div class="cooperate_brand">
                    <h3 class="subtitle">Brand Story - Title</h3>
                    <div class="text">
                        <p>We continuously research and develop new products. Recent years, we have been committed to both domestic and international market development and promotion. The company has comprised well-experienced and trained team of sophisticated management and good operation which is adapt to original design. We take the "quality-oriented", "innovative", "customer first" and "sincere service" concept as our spirit; Stick to take the route of top brand. We have established good operation mechanism of modern enterprise through scientific management system with flexible managerial skills and continuous innovation. We have built a outstanding business team with innovation, competence and passion for excellence. All these have laid a solid foundation for company′s sustainable development. For many years, company has achieved favorable social and economic benefits and won a high admiration and is widely trust at home and abroad by its good reputation, sincere service and overall strength.</p>
                        <p>Now we have sufficient confidence to lead lining fashion trend rely on good quality, superior service, pragmatic business philosophy, scientific management, we are doing better in sales terminal and trying to establish a favorable brand image that let us become one of the high-quality suppliers in textile market, and will create best benefits for our partners to achieve a win-win situation.</p>
                        <p>We look forward to serving you.</p>
                    </div>
                    </div>
                </div>
                </div>
                <div class="cooperate_wall">
                <div class="item"><a class="thumb popup" href="popup_media.html" data-index="0">
                    <!--↓ 16:9，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                    <div class="pic" style="background-image: url(https://via.placeholder.com/936x526);"><img class="size" src="images/size_16x9.png"></div>
                    <!--↑ 16:9，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑--></a></div>
                <div class="item"><a class="thumb is_video popup" href="popup_media.html" data-index="1">
                    <!--↓ 16:9，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                    <div class="pic" style="background-image: url(https://via.placeholder.com/936x526);"><img class="size" src="images/size_16x9.png"></div>
                    <!--↑ 16:9，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑--></a></div>
                <div class="item"><a class="thumb popup" href="popup_media.html" data-index="2">
                    <!--↓ 16:9，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↓-->
                    <div class="pic" style="background-image: url(https://via.placeholder.com/936x526);"><img class="size" src="images/size_16x9.png"></div>
                    <!--↑ 16:9，顯示的圖片放在 pic 的 background-image，img.size 是撐開用的透明圖 ↑--></a></div>
                <div class="item cooperate_link">
                    <h3 class="subtitle">Fusce vehicul.</h3><a class="btn common more" href="javascript:;" target="_blank">Find out</a>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="product_related_wrapper page_block bg_gray">
        <div class="block_inner">
        <h2 class="block_title">You may also like</h2>
        <div class="product_list_slider">
            <div class="slide"><a class="slide_inner" href="product_detail.html">
                <div class="thumb">
                <div class="pic" style="background-image: url(images/img_product01.jpg)"><img class="size" src="images/size_3x4.png"></div>
                </div>
                <h3>Lemite - Sleeveless Eyelet-Lace Dress</h3>
                <div class="price">NT$ 98800</div></a></div>
            <div class="slide"><a class="slide_inner" href="product_detail.html">
                <div class="thumb">
                <div class="pic" style="background-image: url(https://via.placeholder.com/300x400)"><img class="size" src="images/size_3x4.png"></div>
                </div>
                <h3>Lemite - Sleeveless Eyelet-Lace Dress</h3>
                <div class="price">NT$ 98800</div></a></div>
            <div class="slide"><a class="slide_inner" href="product_detail.html">
                <div class="thumb">
                <div class="pic" style="background-image: url(https://via.placeholder.com/300x400)"><img class="size" src="images/size_3x4.png"></div>
                </div>
                <h3>Lemite - Sleeveless Eyelet-Lace Dress</h3>
                <div class="price">NT$ 98800</div></a></div>
            <div class="slide"><a class="slide_inner" href="product_detail.html">
                <div class="thumb">
                <div class="pic" style="background-image: url(https://via.placeholder.com/300x400)"><img class="size" src="images/size_3x4.png"></div>
                </div>
                <h3>Lemite - Sleeveless Eyelet-Lace Dress</h3>
                <div class="price">NT$ 98800</div></a></div>
            <div class="slide"><a class="slide_inner" href="product_detail.html">
                <div class="thumb">
                <div class="pic" style="background-image: url(https://via.placeholder.com/300x400)"><img class="size" src="images/size_3x4.png"></div>
                </div>
                <h3>Lemite - Sleeveless Eyelet-Lace Dress</h3>
                <div class="price">NT$ 98800</div></a></div>
            <div class="slide"><a class="slide_inner" href="product_detail.html">
                <div class="thumb">
                <div class="pic" style="background-image: url(https://via.placeholder.com/300x400)"><img class="size" src="images/size_3x4.png"></div>
                </div>
                <h3>Lemite - Sleeveless Eyelet-Lace Dress</h3>
                <div class="price">NT$ 98800</div></a></div>
            <div class="slide"><a class="slide_inner" href="product_detail.html">
                <div class="thumb">
                <div class="pic" style="background-image: url(https://via.placeholder.com/300x400)"><img class="size" src="images/size_3x4.png"></div>
                </div>
                <h3>Lemite - Sleeveless Eyelet-Lace Dress</h3>
                <div class="price">NT$ 98800</div></a></div>
            <div class="slide"><a class="slide_inner" href="product_detail.html">
                <div class="thumb">
                <div class="pic" style="background-image: url(https://via.placeholder.com/300x400)"><img class="size" src="images/size_3x4.png"></div>
                </div>
                <h3>Lemite - Sleeveless Eyelet-Lace Dress</h3>
                <div class="price">NT$ 98800</div></a></div>
        </div>
        </div>
    </div>
    <div class="product_related_wrapper page_block">
        <div class="block_inner">
        <h2 class="block_title">Recently viewed</h2>
        <div class="product_list_slider">
            <div class="slide"><a class="slide_inner" href="product_detail.html">
                <div class="thumb">
                <div class="pic" style="background-image: url(images/img_product01.jpg)"><img class="size" src="images/size_3x4.png"></div>
                </div>
                <h3>Lemite - Sleeveless Eyelet-Lace Dress</h3>
                <div class="price">NT$ 98800</div></a></div>
            <div class="slide"><a class="slide_inner" href="product_detail.html">
                <div class="thumb">
                <div class="pic" style="background-image: url(https://via.placeholder.com/300x400)"><img class="size" src="images/size_3x4.png"></div>
                </div>
                <h3>Lemite - Sleeveless Eyelet-Lace Dress</h3>
                <div class="price">NT$ 98800</div></a></div>
            <div class="slide"><a class="slide_inner" href="product_detail.html">
                <div class="thumb">
                <div class="pic" style="background-image: url(https://via.placeholder.com/300x400)"><img class="size" src="images/size_3x4.png"></div>
                </div>
                <h3>Lemite - Sleeveless Eyelet-Lace Dress</h3>
                <div class="price">NT$ 98800</div></a></div>
            <div class="slide"><a class="slide_inner" href="product_detail.html">
                <div class="thumb">
                <div class="pic" style="background-image: url(https://via.placeholder.com/300x400)"><img class="size" src="images/size_3x4.png"></div>
                </div>
                <h3>Lemite - Sleeveless Eyelet-Lace Dress</h3>
                <div class="price">NT$ 98800</div></a></div>
            <div class="slide"><a class="slide_inner" href="product_detail.html">
                <div class="thumb">
                <div class="pic" style="background-image: url(https://via.placeholder.com/300x400)"><img class="size" src="images/size_3x4.png"></div>
                </div>
                <h3>Lemite - Sleeveless Eyelet-Lace Dress</h3>
                <div class="price">NT$ 98800</div></a></div>
            <div class="slide"><a class="slide_inner" href="product_detail.html">
                <div class="thumb">
                <div class="pic" style="background-image: url(https://via.placeholder.com/300x400)"><img class="size" src="images/size_3x4.png"></div>
                </div>
                <h3>Lemite - Sleeveless Eyelet-Lace Dress</h3>
                <div class="price">NT$ 98800</div></a></div>
            <div class="slide"><a class="slide_inner" href="product_detail.html">
                <div class="thumb">
                <div class="pic" style="background-image: url(https://via.placeholder.com/300x400)"><img class="size" src="images/size_3x4.png"></div>
                </div>
                <h3>Lemite - Sleeveless Eyelet-Lace Dress</h3>
                <div class="price">NT$ 98800</div></a></div>
            <div class="slide"><a class="slide_inner" href="product_detail.html">
                <div class="thumb">
                <div class="pic" style="background-image: url(https://via.placeholder.com/300x400)"><img class="size" src="images/size_3x4.png"></div>
                </div>
                <h3>Lemite - Sleeveless Eyelet-Lace Dress</h3>
                <div class="price">NT$ 98800</div></a></div>
        </div>
        </div>
    </div>
</main>