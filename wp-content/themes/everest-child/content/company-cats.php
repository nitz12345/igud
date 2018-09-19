<?php
/**
 * Created by PushtooK on 09/03/2018.
 */
?>
<div id="home-header">
    <div id="header-bg">
        <div class="header-inner-width">
            <p>358,332 חברות – <span style="color: #c5a86a;">בית אחד</span></p>
            <h1>איגוד החברות הפרטיות בישראל</h1>
            <div class="home-search">
               <!-- <div class="adv-search"><a href="#" class="search-btn">חיפוש מתקדם</a><div class="clear"></div></div> -->
                <form action="/search-result" class="search-form">
                    <div class="row">
                        <div class="col-md-7">
                            <input type="text" name="search_term" placeholder="חיפוש חופשי">
                        </div>
                        <div class="col-md-3">
							<div class="select-wrapper">
								<i class="fa fa-caret-down" aria-hidden="true"></i>
								<select name="search_area">
									<option value="0">בחר איזור חיפוש</option>
									<?php
									$areas = get_terms(array(
										'taxonomy' => 'company_area',
										'hide_empty' => false
									));
									foreach ($areas as $area){
										echo '<option value="'.$area->term_id.'">'.$area->name.'</option>';
									}
									?>
								</select>
							</div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div class="search-by">
                        <input type="radio" name="search_type" id="free" value="free" checked>
                        <label class="search-by" for="free" data-text="חיפוש חופשי">חיפוש חופשי</label>
                        <input type="radio" name="search_type" id="companyId" value="companyId">
                        <label class="search-by" for="companyId" data-text="חיפוש לפי ח.פ.">חיפוש לפי ח.פ.</label>
                    </div>
                </form>
            </div>
        </div>
        <div class="company-category">
            <?php
								$args = array(
									'taxonomy' => 'company_category',
									'hide_empty' => false,
                  'number' => 15,
									'parent' => 0,
									'orderby' => 'title',
									'order' => 'ASC'
								);
                if (is_front_page() || is_home()){
                  $args['number'] = 10;
                }
								$company_cats = get_terms($args);
                foreach ($company_cats as $company_cat){ ?>
                    <div class="company_cat_details">
                        <a href="<?php echo get_term_link($company_cat) ?>">
													<?php echo wp_get_attachment_image( get_field("company_cat_img", $company_cat), 'medium' ); ?>
													<span class="company-cat-arrow" style="background-color: <?php echo get_field("main_color", $company_cat) ?>; border: 2px solid <?php echo get_field("border_color", $company_cat) ?>;"></span>
													<span class="company-cat-border" style="background-color: <?php echo get_field("border_color", $company_cat) ?>;"></span>
													<span class="company-cat-name"
																style="background-color: <?php echo get_field("main_color", $company_cat) ?>;">
														<?php echo $company_cat->name ?>
													</span>
<!--                        <span class="company-cat-count">--><?php //echo $company_cat->count ?><!-- עסקים</span>-->
                        </a>
                    </div>
                <?php }

            ?>
        </div>
        <?php if (is_front_page()){ ?>
					<a href="<?php echo home_url().'/company_category/'?>" class="pu-more"><span class="full-list-link">לרשימה המלאה</span></a>
        <?php } ?>
    </div>
</div>