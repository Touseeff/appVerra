---
slug: app-store-submission-guide
title: "App Store Submission Without a CTO: A Non-Technical Founder's Walkthrough"
excerpt: "No developer on hand? You can still submit your app. This 2026 walkthrough covers developer accounts, privacy policies, screenshot specs, and the Google Play 14-day testing rule."
meta_title: "App Store Submission Without a CTO: 2026 Founder Guide"
meta_description: "App store submission trips up even technical teams. This 2026 founder walkthrough covers Apple and Google Play — costs, screenshots, and top rejection reasons."
og_image: /assets/images/blog/app-store-submission-guide.jpg
featured_image: /assets/images/blog/app-store-submission-guide.jpg
featured_image_alt: "Two black smartphones on a grey surface showing mobile app login and content discovery screens"
author_name: "AppVerra Editorial"
author_url: "https://appverra.co/about-us"
canonical_url: https://appverra.co/app-store-submission-guide
service_tag: mobile-marketing
unsplash_attribution: "Photo by charlesdeluvio on Unsplash"
unsplash_photographer_url: "https://unsplash.com/@charlesdeluvio"
image_source: unsplash
word_count: 2401
generated_at: 2026-06-24T10:44:56Z
generated_by: claude-code-publish-blog
run_id: 20260624-mm-p26
---
<p>Your app is built. The screens look great. The developer handed you a build file and said "you're ready to submit." Now you're staring at App Store Connect and Google Play Console wondering where to start. This is the moment most non-technical founders hit a wall, not because the process is impossible, but because no one has walked them through it plainly.</p>

<p>Submitting to the Apple App Store and Google Play requires no coding knowledge. What it requires is the right accounts, the right assets, and an understanding of what reviewers actually check. Both stores updated their policies significantly in 2025 and 2026, so guidance from even a year ago may point you toward requirements that no longer apply.</p>

<p>This walkthrough covers both stores in parallel: what accounts you need and what they cost, which assets to prepare before you submit, how privacy labels and data safety forms work, what review timelines to expect, and the most common rejection reasons you can prevent today.</p>

<section id="section1">
<h2 class="heading55px darkpurple">Setting Up Your Developer Accounts</h2>

<p>Before anything else, you need an account on each store you plan to publish to. The costs and setup steps differ between Apple and Google.</p>

<h3>Apple Developer Program</h3>

<p>The <a href="https://developer.apple.com/programs/" target="_blank">Apple Developer Program</a> costs $99 USD per year. That fee covers distribution to 175 regions across all Apple platforms, TestFlight beta testing with up to 10,000 external testers, analytics inside App Store Connect, and worldwide payment processing. A free Apple developer account exists, but it does not allow App Store distribution: the paid membership is mandatory.</p>

<p>If you're registering as an organization, Apple requires a D-U-N-S Number from Dun &amp; Bradstreet. Getting one is free but can take 5–10 business days, so request it before you think you need it. Individuals can enroll under their legal name with no waiting period.</p>

<h3>Google Play Developer Account</h3>

<p>Google Play charges a one-time $25 registration fee with no annual renewal. In 2026, the type of account you register matters. Personal accounts created after November 13, 2023 face an additional hurdle before they can publish to production, covered in the next section. If you can register under a business entity, do so. Organization accounts skip the testing requirement entirely.</p>

<p>Both accounts take a few days to verify, so open them well before your target launch week.</p>
</section>

<section id="section2">
<h2 class="heading55px darkpurple">Apple App Store Submission Requirements 2026</h2>

<p>Apple's submission process runs through App Store Connect, a web dashboard separate from the main developer portal. Before you can submit a build, your developer must upload a binary using Xcode. As of April 28, 2026, <a href="https://developer.apple.com/news/upcoming-requirements/" target="_blank">Apple requires that all new iOS and iPadOS submissions be built with the iOS 26 SDK using Xcode 26 or later</a>. This is a technical requirement your developer handles, but confirm it before they hand over the build.</p>

<p>What you fill in yourself inside App Store Connect:</p>

<ul class="list">
<li><strong>App name</strong> (30-character maximum; trademarked terms and pricing language are prohibited)</li>
<li><strong>Subtitle</strong> (30 characters, shown in search results below the title)</li>
<li><strong>Description</strong> (4,000 characters maximum)</li>
<li><strong>Keywords</strong> (100 characters, comma-separated; these drive search discoverability)</li>
<li><strong>Screenshots</strong> (covered in the assets section below)</li>
<li><strong>Age rating</strong> (Apple generates this from a short questionnaire)</li>
<li><strong>Privacy policy URL</strong> (must be publicly accessible over HTTPS)</li>
<li><strong>Privacy Nutrition Label</strong> data (your data declarations, covered separately below)</li>
</ul>

<p>If your app requires a login to use, <a href="https://developer.apple.com/app-store/review/guidelines/" target="_blank">Apple's review guidelines</a> require that you supply demo account credentials in the review notes field. Reviewers will not create their own accounts. A staging backend that goes offline over the weekend will cause a rejection, so keep your live environment up during the review window.</p>

<p>Apple recommends using TestFlight to run a beta test before submitting to production. This surfaces crashes and gaps reviewers would otherwise flag. It adds a few days to your timeline but saves rejection cycles.</p>
</section>

<section id="section3">
<h2 class="heading55px darkpurple">Google Play Submission Requirements 2026</h2>

<p>Google Play's submission interface is the Play Console. Like App Store Connect, it's a web dashboard where you fill in metadata alongside a build uploaded by your developer. Two requirements specific to 2026 catch first-time publishers off guard.</p>

<h3>The 12-Tester Rule for Personal Accounts</h3>

<p>If you registered a personal developer account after November 13, 2023, you must complete a closed test before Google grants production access. <a href="https://support.google.com/googleplay/android-developer/answer/14151465?hl=en" target="_blank">Google's policy requires at least 12 opted-in testers who remain active for 14 consecutive days</a>. The counter resets if a tester opts out before the 14 days elapse. After that period completes, apply for production access via the Play Console dashboard; Google reviews the request within 7 days.</p>

<p>The requirement was reduced from 20 to 12 testers in December 2024, but it still demands planning. Recruit testers before you think you'll need them. Gmail accounts on real Android devices work best: emulators have caused opt-in failures for some developers. Organization accounts registered as businesses are exempt entirely.</p>

<h3>April 2026 Policy Changes</h3>

<p>A <a href="https://support.google.com/googleplay/android-developer/answer/16926792?hl=en" target="_blank">Google Play policy update effective April 15, 2026</a> changed how apps must handle contact and location permissions. Apps can no longer request broad contacts permissions; they must use the Android Contact Picker instead. Location permissions were also tightened, with the location button now required for precise access. If your app touches contacts or location data, confirm your developer has updated the permission handling before submission.</p>

<p>Google Play does not have a fixed review timeline. Most submissions clear within a few hours to a few days, but policy reviews for certain categories can take longer. Plan for a week of buffer before your target launch date.</p>
</section>

<section id="section4">
<h2 class="heading55px darkpurple">Preparing Your App Store Assets</h2>

<p>The assets section trips up more non-technical founders than the technical requirements. Screenshots and preview graphics cannot be improvised the night before submission. Plan them early.</p>

<h3>Screenshot Specifications</h3>

<p>For iOS, <a href="https://developer.apple.com/help/app-store-connect/reference/app-information/screenshot-specifications/" target="_blank">Apple requires screenshots at exact pixel dimensions</a>. You need at least one set of iPhone screenshots: either 6.9-inch (1320x2868 pixels, portrait) or 6.5-inch (1284x2778 pixels, portrait). One set scales to all smaller iPhone displays. If your app supports iPad, you'll also need a 13-inch iPad set at 2064x2752 pixels. Files must be JPEG or PNG, RGB color, no transparency. Screenshots must show actual app use, not splash screens or promotional graphics.</p>

<p>Google Play requires a feature graphic (1024x500 pixels) and at least two screenshots. Screenshot dimensions are flexible, though Google recommends hi-res assets for both tablet and phone displays.</p>

<h3>Review Notes</h3>

<p>Both stores allow review notes visible only to the reviewer. Use this field. Good review notes include test account credentials, a brief description of features and how to reach them, any third-party services your app connects to, and a contact email if the reviewer needs clarification. Apps that skip review notes and require login face higher rejection rates simply because reviewers cannot access core functionality.</p>
</section>

<section id="section5">
<h2 class="heading55px darkpurple">Privacy Policies and Data Labels: What Both Stores Require</h2>

<p>Both Apple and Google require a privacy policy before your app can go live. The policy must sit at a publicly accessible HTTPS URL, identify what data is collected, explain how it is used, and describe how users can withdraw consent. A policy behind a login or embedded as a PDF attachment will fail both stores' requirements.</p>

<h3>Apple's Privacy Nutrition Label</h3>

<p>Inside App Store Connect, you'll complete a data disclosure questionnaire that generates the Privacy Nutrition Label shown on your app's product page. <a href="https://developer.apple.com/app-store/app-privacy-details/" target="_blank">Apple requires you to disclose all 17 data categories</a>, including contact info, health data, financial data, location, identifiers, and usage data, for both your own app and any third-party SDKs it uses. You cannot delegate this responsibility to the SDK vendor. If your analytics tool collects device identifiers, you must disclose it.</p>

<p>Since May 2024, Apple also requires privacy manifest files (PrivacyInfo.xcprivacy) for apps using certain APIs. Missing these files triggers automated rejection. Ask your developer to confirm the privacy manifest is included before they upload the build.</p>

<h3>Google Play's Data Safety Form</h3>

<p>The <a href="https://support.google.com/googleplay/android-developer/answer/10787469?hl=en" target="_blank">Data Safety section in Play Console</a> works similarly. You disclose what data your app collects, what it shares with third parties, and what security practices you follow. The same rule applies: you must account for every SDK your app includes, even if that SDK's vendor does their own disclosure elsewhere. On-device data and fully anonymized data are excluded from disclosure requirements.</p>

<p>Budget 2 to 3 hours to complete both privacy forms carefully. Inaccuracies between your disclosures and your app's actual behavior are a policy violation and a removal risk after launch.</p>
</section>

<section id="section6">
<h2 class="heading55px darkpurple">App Store Review Process and Timelines</h2>

<p>Once you submit, your app enters a review queue. Knowing the timeline lets you plan your launch and marketing schedule without scrambling.</p>

<h3>Apple App Store Review Times</h3>

<p><a href="https://www.runway.team/appreviewtimes" target="_blank">Runway's live review tracker</a>, which aggregates data from development teams, shows that as of June 18, 2026, the average wait before a reviewer picks up your submission is 8 hours and 42 minutes, with the actual review averaging 1 hour and 16 minutes. Most apps hear a result within 10 to 12 hours of submission.</p>

<p>Day of week matters. Saturdays average nearly 20 hours of waiting; Wednesdays average under 8 hours. January 2026 saw the longest waits of the year. If your launch date is flexible, submit Tuesday or Wednesday morning US Eastern time.</p>

<p>First-time app submissions are different. <a href="https://adapty.io/blog/how-to-pass-app-store-review/" target="_blank">Adapty's 2026 review checklist</a> notes that first submissions can take up to one month. Apple may request screencasts of app functionality, intellectual property proof, or encryption documentation that ongoing developers rarely encounter. Build that buffer into your timeline.</p>

<h3>Google Play Review Times</h3>

<p>Google's review timeline is less predictable. Most new app submissions clear within a few hours, but policy-flagged submissions or apps in sensitive categories can take several days. Unlike Apple, Google does not expose in-review status via its Publishing API, so you won't see granular progress updates.</p>
</section>

<section id="section7">
<h2 class="heading55px darkpurple">Common Rejection Reasons and How to Prevent Them</h2>

<p>Rejection does not mean failure. It means something specific needs fixing. Most first-time submissions fail for one of a handful of reasons, all preventable.</p>

<ul class="list">
<li><strong>App crashes during review.</strong> Human reviewers test on physical devices. A crash in onboarding or checkout means immediate rejection. Test on real devices before submitting, not just the simulator.</li>
<li><strong>Missing or inaccessible privacy policy.</strong> Both stores check that the URL works and returns a real page. A 404, a redirect loop, or a login-gated page fails the check. Confirm the URL loads cleanly from an incognito browser window.</li>
<li><strong>Screenshots misrepresent the app.</strong> If your screenshots show features not in the submitted build, or use device frames Apple doesn't recognize, reviewers flag it. Show what the app actually does.</li>
<li><strong>Sign in with Apple is missing.</strong> If your app offers Facebook or Google login, <a href="https://developer.apple.com/app-store/review/guidelines/" target="_blank">Guideline 4.8 requires Sign in with Apple as well</a>. This is one of the most common first-submission surprises for apps built with social login.</li>
<li><strong>In-app purchases route around Apple's system.</strong> Any digital goods sold inside an iOS app must use Apple's In-App Purchase system. QR codes, external payment links, and license key flows are prohibited. The <a href="https://capgo.app/blog/first-time-app-review-guide/" target="_blank">2026 first-time submission guide from Capgo</a> lists this as a consistent top rejection cause.</li>
<li><strong>Missing privacy manifest file.</strong> Apps using certain Apple APIs require a PrivacyInfo.xcprivacy manifest. Automated rejection happens before a human reviewer even sees the build.</li>
</ul>

<p>After a rejection, resubmissions typically review within 24 to 48 hours rather than going to the back of the full queue. Fix the flagged issue, reply in the Resolution Center if clarification helps, and resubmit.</p>
</section>

<section id="section8">
<h2 class="heading55px darkpurple">FAQs on App Store Submission</h2>

<p><strong>Q: Do I need a developer account to submit an app to the App Store?</strong><br>Yes. Both Apple and Google require a registered developer account before you can submit any app. Apple charges $99 per year; Google charges a one-time $25 fee. A free Apple developer account exists but does not allow App Store distribution.</p>

<p><strong>Q: How long does Apple App Store review take in 2026?</strong><br>Most updates clear in 8 to 10 hours. First-time submissions can take up to one month, as Apple may request additional documentation. Submit mid-week to avoid Saturday slowdowns.</p>

<p><strong>Q: Can a non-technical founder submit an app without a developer?</strong><br>You can fill in metadata, screenshots, privacy labels, and review notes yourself. However, uploading the binary requires Xcode on Apple or Android build tools on Google Play. Most founders handle the listing and have their developer upload the build.</p>

<p><strong>Q: What are the most common reasons Apple rejects an app?</strong><br>Crashes during review, a missing or broken privacy policy URL, screenshots that misrepresent functionality, missing Sign in with Apple when social login is offered, and in-app purchases that bypass Apple's payment system. Each is fixable before submission.</p>

<p><strong>Q: How many testers do I need for Google Play submission?</strong><br>If you registered a personal Google Play developer account after November 13, 2023, you need at least 12 opted-in testers who stay active for 14 consecutive days before you can apply for production access. Organization accounts are exempt.</p>

<p><strong>Q: What screenshots are required for App Store submission?</strong><br>At minimum, one set of iPhone screenshots at either 1320x2868 pixels (6.9-inch) or 1284x2778 pixels (6.5-inch), in JPEG or PNG format with no transparency. iPad screenshots are required separately if your app supports iPad. Screenshots must show the app in actual use, not splash or promotional screens.</p>

<p><strong>Q: Do I need a privacy policy to submit an app?</strong><br>Yes. Both Apple and Google require a publicly accessible privacy policy URL before submission. The policy must explain what data is collected, how it is used, and how users can opt out. A page that requires login or returns a 404 will cause rejection.</p>
</section>

<section id="section9">
<h2 class="heading55px darkpurple">Final Thoughts</h2>

<p>Getting an app approved on the Apple App Store and Google Play is genuinely achievable without a technical co-founder, once you understand what each store is actually checking. The accounts are affordable, the metadata is straightforward, and the most common rejections are avoidable with preparation. The harder part is what comes after approval: building an ASO strategy, acquiring early ratings, and turning launch day into sustained downloads. Once your app clears review, <a href="https://appverra.co/services/mobile-app-marketing" target="_blank">AppVerra's mobile app marketing team</a> can build the launch and growth strategy that converts that approval into real, compounding traction.</p>
</section>

<section id="section10">
<h2 class="heading55px darkpurple">Sources</h2>
<ul class="ul_list">
<li><a href="https://developer.apple.com/app-store/submitting/" target="_blank">Submitting to the App Store (Apple Developer)</a></li>
<li><a href="https://developer.apple.com/app-store/review/guidelines/" target="_blank">App Review Guidelines (Apple Developer)</a></li>
<li><a href="https://developer.apple.com/news/upcoming-requirements/" target="_blank">Upcoming Requirements (Apple Developer)</a></li>
<li><a href="https://developer.apple.com/programs/" target="_blank">Apple Developer Program</a></li>
<li><a href="https://developer.apple.com/app-store/app-privacy-details/" target="_blank">App Privacy Details (App Store, Apple Developer)</a></li>
<li><a href="https://developer.apple.com/help/app-store-connect/reference/app-information/screenshot-specifications/" target="_blank">Screenshot Specifications (App Store Connect, Apple Developer)</a></li>
<li><a href="https://support.google.com/googleplay/android-developer/answer/10787469?hl=en" target="_blank">Data Safety Section (Play Console Help, Google)</a></li>
<li><a href="https://support.google.com/googleplay/android-developer/answer/14151465?hl=en" target="_blank">App Testing Requirements for New Developer Accounts (Play Console Help, Google)</a></li>
<li><a href="https://support.google.com/googleplay/android-developer/answer/16926792?hl=en" target="_blank">Policy Announcement: April 15, 2026 (Play Console Help, Google)</a></li>
<li><a href="https://www.runway.team/appreviewtimes" target="_blank">Live App Store Review Times (Runway)</a></li>
<li><a href="https://adapty.io/blog/how-to-pass-app-store-review/" target="_blank">App Store Review Guidelines 2026: Updated Checklist (Adapty)</a></li>
<li><a href="https://capgo.app/blog/first-time-app-review-guide/" target="_blank">The Complete First-Time App Review Guide for 2026 (Capgo)</a></li>
</ul>
</section>
