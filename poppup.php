<style>
    .overlay-bg-new-popup {background: rgb(0 0 0 / 33%); position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100%; height: 100%; z-index: 998; opacity: 0; visibility: hidden; transition: opacity 0.5s ease-in-out, visibility 0.5s ease-in-out; }
    .overlay-bg-new-popup.active {opacity: 1; visibility: visible; }
    .popupform-main-new-popup {position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; display: flex; justify-content: center; align-items: center; backdrop-filter: blur(7px); opacity: 0; visibility: hidden; transition: opacity 0.5s ease-in-out, visibility 0.5s ease-in-out;}
    .pop-form-new-popp.ta-center-new-pop {background-size: cover; padding: 30px; border-radius: 25px; /*overflow: hidden;*/ transform: translateY(20px); opacity: 0; transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out; position: relative; max-width: 600px; background-color: #fff;}
    .popupform-main-new-popup.active {opacity: 1; visibility: visible; }
    .popupform-main-new-popup.active .pop-form-new-popp.ta-center-new-pop {transform: translateY(0); opacity: 1;}
    .pop-form-new-popp.ta-center-new-pop input, .pop-form-new-popp.ta-center-new-pop textarea, .pop-form-new-popp.ta-center-new-pop select {width: 100%; border: 1px solid #00000029 !important; border-radius: 10px;  background: transparent; margin-bottom: 10px; padding: 10px 0 10px 20px; outline: none !important; font-weight: 400; font-size: 13px; }
    .close-btn {width: 35px; height: 35px; background: var(--primeColor); border: 0; color: var(--black); font-weight: 200; font-size: 39px; line-height: 0; transform: rotate(45deg); display: flex; justify-content: center; align-items: center; border-radius: 50%; position: absolute; top: -10px; right: -10px; cursor: pointer; z-index: 99;}
    .close-btn span {position: relative; left: 0; top: -2px; }
    .pop-form-new-popp .checkbox_wrapper {gap:10px; }
    .pop-form-new-popp .checkbox_wrapper .custm_checkBox {margin: 0; }
    .pop-form-new-popp .checkbox_wrapper .custm_checkBox input:checked ~ .checkmark {color: #000 !important; }
    .pop-form-new-popp.ta-center-new-pop ::placeholder {color: #000; opacity: 0.5; }
    img.popup_logo {width: 100px; margin-bottom: 20px; height: auto !important; }
    img.pop_icon {top: 13px; }
    img.popup_bg {position: absolute; width: 102%; left: -7px; top: 0; opacity: 0.8; height: 102%; }
    @media(max-width: 767px) {
    .pop-form-new-popp.ta-center-new-pop {padding: 20px; border-radius: 15px; }
    .pop-form-new-popp.ta-center-new-pop input, .pop-form-new-popp.ta-center-new-pop textarea, .pop-form-new-popp.ta-center-new-pop select {border-radius: 7px; margin-bottom: 5px; padding: 5px 0 5px 10px; font-size: 11px; }
    .checkmark {padding: 6px 11px; font-size: 12px; }
    img.popup_logo {width: 60px; margin-bottom: 20px; }
    .pop-form-new-popp.ta-center-new-pop {width: 90% !important; }
    }
</style>
<div class="overlay-bg-new-popup"></div>
<div class="popupform-main-new-popup">
    <div class="pop-form-new-popp ta-center-new-pop position-relative col-lg-5 col-md-7">
        <!-- <img src="assets/images/pop-form-bg.webp" loading="lazy" class="popup_bg" alt="" loading="lazy" /> -->
        <a href="javascript:;" class="close-btn ta-center"><span>+</span></a>
        <form action="/mail" method="POST" class="position-relative">
            <div class="titleWrap text-center">
                <img src="assets/images/popup-img3.webp" loading="lazy" class="popup_logo" alt="" loading="lazy" width="60" height="34" />
            </div>
            <div class="row">
                <div class="col-6 position-relative">
                    <input type="text" name="name" placeholder="Enter Your Name" required>
                </div>
                <div class="col-6 position-relative">
                    <input type="number" name="number" placeholder="Enter Your Phone Number" required class="numberValidation">
                </div>
                <div class="col-6 position-relative">
                    <input type="email" name="email" placeholder="Enter Your Email Address " required>
                </div>
                <div class="col-6 position-relative">
                    <select class="input" name="budget">
                        <option selected="" hidden="" value="Choose Your Budget">Choose Your Budget</option>
                        <option value="1500 – 2999">$1500 – $2999</option>
                        <option value="3000 – 4999">$3000 – $4999</option>
                        <option value="5000 – 6499">$5000 – $6499</option>
                        <option value="6500 and above">$6500 and above</option>
                    </select>
                </div>
                <div class="col-12 position-relative">
                    <textarea class="input" name="msg" placeholder="Write a message"></textarea>
                </div>
                <div class="col-12">
                    <h6 class="heading20px my-1 fw_600 dark">Select Services</h6>
                    <div class="checkbox_wrapper mt-3">
                        <label class="custm_checkBox">
                            <input type="checkbox" name="service[]" value="Unity Game Development" checked="">
                            <span class="checkmark d-flex align-items-center gap-2">
                                <img src="assets/images/tech-iccon1.svg" loading="lazy" class="technology_icon" width="" height="" alt="">
                                Unity Game Development
                            </span>
                        </label>
                        <label class="custm_checkBox">
                            <input type="checkbox" name="service[]" value="React Native Development">
                            <span class="checkmark d-flex align-items-center gap-2">
                                <img src="assets/images/tech-iccon2.svg" loading="lazy" class="technology_icon" width="" height="" alt="">
                                React Native Development
                            </span>
                        </label>
                        <label class="custm_checkBox">
                            <input type="checkbox" name="service[]" value="Flutter Development">
                            <span class="checkmark d-flex align-items-center gap-2">
                                <img src="assets/images/tech-iccon3.svg" loading="lazy" class="technology_icon" width="" height="" alt="">
                                Flutter Development
                            </span>
                        </label>
                        <label class="custm_checkBox">
                            <input type="checkbox" name="service[]" value="Full Stack Development">
                            <span class="checkmark d-flex align-items-center gap-2">
                                <img src="assets/images/tech-iccon4.svg" loading="lazy" class="technology_icon" width="" height="" alt="">
                                Full Stack Development
                            </span>
                        </label>
                        <label class="custm_checkBox">
                            <input type="checkbox" name="service[]" value="Mobile App Marketing">
                            <span class="checkmark d-flex align-items-center gap-2">
                                <img src="assets/images/tech-iccon6.svg" loading="lazy" class="technology_icon" width="" height="" alt="">
                                Mobile App Marketing
                            </span>
                        </label>
                        <label class="custm_checkBox">
                            <input type="checkbox" name="service[]" value="Any Ecommerce">
                            <span class="checkmark d-flex align-items-center gap-2">
                                <img src="assets/images/tech-iccon7.svg" loading="lazy" class="technology_icon" width="" height="" alt="">
                                Any Ecommerce
                            </span>
                        </label>
                    </div>
                </div>
                <div class="col-12 mt-3 text-center">
                    <span class="btn_wrap"  data-aos="fade-up" data-aos-delay="600">
                        <button type="submit" class="theme_btn pop_btn">
                            <span class="btnTextWrap">
                                <span>Submit</span>
                                <span>Submit</span>
                            </span>
                            <span class="iconCircle">
                                <span class="iconWrap">
                                    <i data-feather="arrow-right"></i>
                                    <i data-feather="arrow-right"></i>
                                </span>
                            </span>
                        </button>
                    </span>
                </div>
            </div>
            <input type="hidden" name="page_url" value="<?= 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
            <input type="hidden" name="ip" value="<?= $_SERVER['REMOTE_ADDR']; ?>">
            <input type="hidden" name="isp" value="<?= htmlspecialchars($isp); ?>">
            <input type="hidden" name="org" value="<?= htmlspecialchars($org); ?>">
            <input type="hidden" name="country" value="<?= htmlspecialchars($country); ?>">
            <input type="hidden" name="region" value="<?= htmlspecialchars($region); ?>">
            <input type="hidden" name="city" value="<?= htmlspecialchars($city); ?>">
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const popup = document.querySelector(".popupform-main-new-popup");
        const overlay = document.querySelector(".overlay-bg-new-popup");
        const openButtons = document.querySelectorAll(".pop_btn");
        const closeButton = document.querySelector(".close-btn");
        openButtons.forEach(function (btn) {
            btn.addEventListener("click", function () {
                popup.classList.add("active");
                overlay.classList.add("active");
                // document.body.style.overflow = "hidden";
            });
        });
        function closePopup() {
            popup.classList.remove("active");
            overlay.classList.remove("active");
            // document.body.style.overflow = "";
        }

        closeButton.addEventListener("click", closePopup);
        overlay.addEventListener("click", closePopup);


        // document.querySelector('.popupform-main-new-popup form').addEventListener("submit", function (e) {
        //     let phoneFields = e.target.querySelectorAll('input[type="number"]');
        //     let isValid = true;

        //     phoneFields.forEach(function (field) {
        //         let value = field.value.trim();
        //         if (!/^\d{11}$/.test(value)) {
        //             isValid = false;
        //             field.style.borderBottom = "1px solid red"; // Highlight invalid
        //         } else {
        //             field.style.borderBottom = ""; // Reset if valid
        //         }
        //     });

        //     if (!isValid) {
        //         e.preventDefault(); // Stop form submit
        //         alert("Phone number must be exactly 11 digits");
        //     }
        // });

        // document.querySelector('form').addEventListener("submit", function (e) {
        //     let phoneFields = document.querySelectorAll('input[type="number"]');
        //     let isValid = true;

        //     phoneFields.forEach(function (field) {
        //         let value = field.value.trim();
        //         if (!/^\d{11}$/.test(value)) {
        //             isValid = false;
        //             field.style.borderBottom = "1px solid red"; // Highlight invalid
        //         } else {
        //             field.style.borderBottom = ""; // Reset if valid
        //         }
        //     });

        //     if (!isValid) {
        //         e.preventDefault(); // Stop form submit
        //         alert("Phone number must be 11 digits");
        //     }
        // });
    });



</script>
