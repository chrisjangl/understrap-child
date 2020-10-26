<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 * 
 * @todo: make sure to remove all JS code - <% %>
 * @todo: the_custom_logo() links to the WP site url
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="wrapper" id="wrapper-footer">

    <footer id="colophon" class="site-footer page-footer bg-blue-dark font-small white">

        <!-- Footer Links -->
        <section class="container-fluid text-md-left">

            <!-- Grid row -->
            <div class="row">

                <!-- Grid column -->
                <div class="col-md-5 ">
                    <div class="row">

                        <div class="col-md-4">
                                <?php the_custom_logo(); ?>
                        </div>
                        <!-- Content -->
                        <div class="col-md-8">

                            <h5 class="text-uppercase gold mb-1">Customer Service</h5>
                            <ul class="list-unstyled">
                                <li><a href="tel:888-656-3647">888-656-DOGS(3647)</a></li>
                                <li><a href="mailto:orders@usaservicedogs.org">orders@usaservicedogs.org</a></li>
                            </ul>
                            <ul class="list-unstyled font-weight-bold">
                                <li><a href="<%= siteVars.url %>/contact">Contact Us</a></li>
                                <li><a href="<%= siteVars.url %>/lookup">ID Lookup</a></li>
                                <li><a href="<%= siteVars.url %>/members">Members</a></li>
                                <li><a href="<%= siteVars.url %>/return-policy">Return Policy</a></li>
                                <li><a href="<%= siteVars.url %>/faq">FAQs</a></li>
                                <li><a href="<%= siteVars.url %>/sitemap">Site Map</a></li>
                            </ul>
                        </div>

                    </div>

                </div>

                <hr class="col-8 bg-white d-md-none my-4 mx-auto">

                <!-- Grid column -->
                <div class="border-left border-white col-md-6 text-uppercase h5">

                    <!-- Links -->

                    <ul class="list-unstyled">
                        <li><a href="<%= siteVars.url %>/register/service-dog-registration/">Register Service Dog</a></li>
                        <li><a href="<%= siteVars.url %>/register/emotional-support-dog-registration/">Register Emotional Support Dog</a></li>
                        <li><a href="<%= siteVars.url %>/shop/">Shop</a></li>
                        <li><a href="<%= siteVars.url %>/more-information/">Info Center</a></li>
                        <li><a href="<%= siteVars.url %>/blog/">Blog</a></li>
                    </ul>

                </div>
                <!-- Grid column -->

            </div>
            <!-- Grid row -->

        </section>
        <!-- Footer Links -->

        <!-- Copyright -->
        <section class="footer-copyright container-fluid py-0 mb-5">
            <div class="colophon mb-4">
                Copyright &copy; 2012-2020 USA Service Dogs. All rights reserved.
            </div>

            <small>USA Service Dogs uses industry standard 256-bit encryption to secure the data you send to us including
                personal information accompanying your registration as well as payment information. We do not store credit
                numbers anywhere on our servers, they are used once only at the time the transaction occurs. We collect your
                e-mail address only to send you order confirmation emails, registration information, and occasional news and
                updates about our service. We do not sell or give any of your information, including your e-mail address, to
                any third party organizations. USA Service Dogs is an organization providing service dog and emotional
                support animal registration services and products independent of any government organization. Read about
                fake service dog registrations and the problems they create. Registration not required by the ADA.<br />
                v1.0.24</small>
        </section>
        <!-- Copyright -->

        <section class="no-border py-4" id="powered-by">
            <div class="container">

                <div class="row">

                        <img src="/<%= siteVars.public_folder %>/images/powered-by.png" alt="">

                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
        </section>
        <!-- end #powered-by -->

    </footer><!-- #colophon -->

</div><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

