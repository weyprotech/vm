    <!--↓ 後台可設定網站五個顏色 ↓ -- bg_brown、bg_red、bg_purple、bg_blue、bg_green-->
    <div class="header_top <?= $website_color->color ?>">
        <div class="header_top_inner">
            <div class="links">
                <!-- <a href="javascript:;">SHIPPING</a><i class="divide_line"></i><a href="javascript:;">REFUND</a> -->
            </div>
            <div class="marquee">FREE SHIPPING. EASY RETURN.</div>
            <div class="currency_language">
                <div class="select_wrapper">
                    <select class="money_type_select">
                        <option>€ EUR</option>
                        <option>$ TWD</option>
                        <option>¥ CNY</option>
                    </select>
                </div><i class="divide_line"></i>
                <div class="select_wrapper">
                    <select class="languange_select">
                        <option value='en' <?=($this->langFile=="en"?"selected":"")?>>English</option>
                        <option value='tw' <?=($this->langFile=="tw"?"selected":"")?>>繁體中文</option>
                        <option value='cn' <?=($this->langFile=="cn"?"selected":"")?>>简体中文</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <!--↑ 後台可設定網站五個顏色 ↑ -- bg_brown、bg_red、bg_purple、bg_blue、bg_green-->