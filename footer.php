

<footer>

	<div class="footer light">

		<div class="container mb-lg-5 mb-4">

			<div class="row">

				<div class="col-lg-3 col-md-6 mb-4 mb-md-0">

					<div class="f_clm f_clm2">

						<h3 class="heading40px">Quick links</h3>

						<ul >

							<li><a href="<?php echo $siteurl; ?>">HOME</a></li>

							<li><a href="about-us">ABOUT US</a></li>

							<li><a href="our-services">OUR SERVICES</a></li>

							<li><a href="our-work">WORK</a></li>

							<li><a href="contact-us">CONTACT US</a></li>

						</ul>

					</div>

				</div>

				<div class="col-lg-3 col-md-6 mb-4 mb-md-0">

					<div class="f_clm f_clm2">

						<h3 class="heading40px">Services</h3>

						<ul >

			                <li><a href="unity-game-development">UNITY GAME DEVELOPMENT</a></li>

			                <li><a href="react-native-developer">REACT NATIVE DEVELOPMENT</a></li>

			                <li><a href="flutter-app-development">FLUTTER APP DEVELOPMENT</a></li>

			                <li><a href="full-stack-development">FULL STACK DEVELOPMENT</a></li>

			                <li><a href="mobile-app-marketing">MOBILE APP MARKETING</a></li>

			                <li><a href="ecommerce">ANY ECOMMERCE </a></li>

						</ul>

					</div>

				</div>

				<div class="col-lg-3 col-md-6 mb-4 mb-md-0">

					<div class="f_clm f_clm3">

						<h3 class="heading40px">Contact Us</h3>

						<h4 class="heading20px mb-0">Email Us:</h4>

						<a href="mailto:<?= $siteemail ?>"><?= $siteemail ?></a>

						<h4 class="heading20px mb-0 mt-3">Phone:</h4>

						<a href="tel:<?= $tel ?>"><?= $sitenumber ?></a>

					</div>

				</div>

				<div class="col-lg-3 col-md-6 mb-4 mb-md-0">

					<div class="f_clm f_clm4">

						<h3 class="heading40px">Location</h3>

						<div class="d-flex gap-2 align-items-star">

							<img src="assets/images/mark2.svg" loading="lazy" class="mark_img" width="30" height="69" alt=""/>

							<div class="txt_box">

								<!--<h4 class="heading20px mb-0">LOCATION:</h4>-->

								<p class="m-0"><?= $siteaddress ?></p>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

		<!-- <span class="heading187px fw_700">

			<span class="half_txt">

				<span class="sing_alphabet">C</span>

				<span class="sing_alphabet">O</span>

				<span class="sing_alphabet">D</span>

				<span class="sing_alphabet">E</span>

				<span class="sing_alphabet">F</span>

				<span class="sing_alphabet">L</span>

				<span class="sing_alphabet">O</span>

				<span class="sing_alphabet">W</span>

				<span class="sing_alphabet">A</span>

				<span class="sing_alphabet">P</span>

				<span class="sing_alphabet">P</span>

				<span class="sing_alphabet">S</span>

			</span>

		</span> -->

		<span class="revealUp">

			<span>

				<span class="heading187px fw_700 uppercase"> <?= $sitename ?> </span>

			</span>

		</span>

	</div>

	<div class="copyright">

		<div class="container light">

			<div class="row">

				<div class="col-md-7 mb-2 mb-md-0">

					<p>© 2026 <span class="green"><?php echo $sitename ; ?></span> — Powered by <span class="green">Artistic Web Services</span></p>

				</div>

				<div class="col-md-5">

					<div class="btn_set">

						<a href="<?php echo $siteurl; ?>terms-and-condition">Terms of Services</a>

						<a href="<?php echo $siteurl; ?>privacy-policy">Privacy Policy</a>

					</div>

				</div>

			</div>

		</div>

	</div>

</footer>

</div>

</div>

<?php include("poppup.php"); ?>

<!-- JavaScript — defer keeps execution order, releases main thread faster -->
<script src="/assets/js/jquery.js" defer></script>
<script src="/assets/js/bootstrap.min.js" defer></script>
<script src="/assets/js/owl.carousel.min.js" defer></script>
<script src="/assets/js/slick.min.js" defer></script>
<script src="/assets/js/gsap.min.js" defer></script>
<script src="/assets/js/feather.min.js" defer></script>
<script src="/assets/js/ScrollTrigger.min.js" defer></script>
<script src="/assets/js/aos.js" defer></script>
<script src="/assets/js/scrollsmoother.min.js" defer></script>
<script src="/assets/js/custom.js" defer></script>



</body>

</html>