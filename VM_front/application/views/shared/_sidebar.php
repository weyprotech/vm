<div id="sidebar">
      <nav class="sidebar_menu">
        <ul>
          <li><a href="<?= site_url('brand') ?>"><?=langText('header', 'brands') ?></a></li>
          <li><a href="<?= site_url('designers') ?>"><?=langText('header', 'designers') ?></a></li>
          <?php foreach($categoryList as $firstKey => $firstValue){ ?>
          <li><a href="<?= site_url('product/index?baseId='.$firstValue->categoryId) ?>"><?= $firstValue->name ?></a>
            <div class="sub_menu">
              <ul>
              <?php if(!empty($categoryList[$firstKey]->categoryList)){ ?>
                <?php foreach($categoryList[$firstKey]->categoryList as $subKey => $subValue){ ?>
                <li><a href="<?= site_url('product/index?subId='.$subValue->categoryId) ?>"><?= $subValue->name ?></a>
                  <ul>
                  <?php if(!empty($categoryList[$firstKey]->categoryList[$subKey]->categoryList)){ ?>
                    <?php foreach($categoryList[$firstKey]->categoryList[$subKey]->categoryList as $categoryKey => $categoryValue){ ?>
                    <li><a href="<?= site_url('product/index?categoryId='.$categoryValue->categoryId) ?>"><?= $categoryValue->name ?></a></li>
                    <?php } ?>
                  <?php } ?>
                  </ul>
                </li>
                <?php } ?>
              <?php } ?>
              </ul>
            </div>
          </li>
          <?php } ?>
          <li><a href="<?= site_url('sale') ?>"><?=langText('header', 'sale') ?></a></li>
          <li><a href="<?= site_url('events') ?>"><?=langText('header', 'events') ?></a></li>
          <li><a href="<?= site_url('popular_designers') ?>"><?=langText('header', 'popular_designers') ?></a></li>
        </ul>
        <div class="links"><a href="javascript:;">SHIPPING</a><i class="divide_line"></i><a href="javascript:;">REFUND</a></div>
        <div class="currency_language">
          <div class="select_wrapper">
            <select>
              <option>€ EUR</option>
              <option>$ TWD</option>
              <!-- <option>¥ CNY</option> -->
            </select>
          </div>
          <div class="select_wrapper">
            <select>
              <option selected>English</option>
              <option>繁體中文</option>
              <!-- <option>简体中文</option> -->
            </select>
          </div>
        </div>
      </nav>
    </div>
    <div class="popup_block mfp-hide" style="width: 480px" id="popupEntrance">
      <div class="popup_inner">
        <div class="controls_group">
          <label>Currency</label>
          <div class="select_wrapper">
            <select id="money_type_select">
              <option value="eur">€ EUR</option>
              <option value="twd">$ TWD</option>
              <!--<option>¥ CNY</option>-->
            </select>
          </div>
        </div>
        <div class="controls_group">
          <label>Language</label>
          <div class="select_wrapper">
            <select id="language_select">
              <option value='en' <?=($this->langFile=="en")?"selected":""?>>English</option>
              <option value='tw' <?=($this->langFile=="tw")?"selected":""?>>繁體中文</option>
              <!--<option value='cn'>简体中文</option>-->
            </select>
          </div>
        </div>
        <button class="btn confirm popup_modal_dismiss" id="website_set" type="button">Save</button>
      </div>
    </div>