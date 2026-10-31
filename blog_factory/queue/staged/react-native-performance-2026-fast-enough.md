---
slug: react-native-performance-2026-fast-enough
title: "React Native Performance in 2026: Is It Fast Enough for Your App?"
excerpt: "Is React Native fast enough in 2026? We break down what the New Architecture and Hermes V1 changed, how to fix slow lists, and when native code is the better call."
meta_title: "React Native Performance in 2026: Is It Fast Enough?"
meta_description: "React Native performance in 2026 is better than its reputation. See what the New Architecture and Hermes V1 changed, and when native still wins."
og_image: /assets/images/blog/react-native-performance-2026-fast-enough.jpg
featured_image: /assets/images/blog/react-native-performance-2026-fast-enough.jpg
featured_image_alt: "Hand holding a smartphone that displays lines of source code on its screen"
author_name: "AppVerra Editorial"
author_url: "https://appverra.co/about-us"
canonical_url: https://appverra.co/react-native-performance-2026-fast-enough
service_tag: react-native
unsplash_attribution: "Photo by Andrey Matveev on Unsplash"
unsplash_photographer_url: "https://unsplash.com/@zelebb"
image_source: unsplash
word_count: 2330
generated_at: 2026-10-31T16:13:21Z
generated_by: claude-code-publish-blog
run_id: 20261031-210613
---

<p>You are about to commit a year of budget to a cross-platform codebase, and one question keeps surfacing in the review meeting: will it feel slow? Most of the answers you will find online are either vendor cheerleading or a year-old benchmark from a different architecture.</p>

<p>The honest picture of React Native performance in 2026 is more interesting than either camp admits. The old JavaScript bridge is gone, Hermes V1 is the default engine, and the tooling for finding bottlenecks has matured. At the same time, the React Native team itself publishes few hard benchmark numbers, and the gains it does publish are modest and app-dependent.</p>

<p>This post sticks to figures from official release notes and named engineering teams at Shopify, Expensify, and Discord. You will see what actually changed, where speed comes from in practice, and when you should pick something else.</p>

<section id="section1">
<h2 class="heading55px darkpurple">Is React Native Fast Enough in 2026?</h2>
<p>For the typical business app, yes. Think onboarding flows, feeds, forms, checkout, maps, and dashboards. The usual failure is rarely the framework. It is a specific screen doing too much work on the JavaScript thread, and nobody profiling it until users complain.</p>

<p>The <a href="https://reactnative.dev/docs/performance" target="_blank">official React Native performance overview</a> frames the target clearly: 60 FPS, which leaves each frame at most 16.67 ms of work. It also notes that UI-thread scrolling stays smooth even when JavaScript is busy, while a 200 ms JS re-render could drop roughly 12 frames. That distinction is the whole game. Native-driven interactions are cheap. JavaScript-driven ones are where you pay.</p>

<p>Scale is not the blocker either. In the <a href="https://devclass.com/2025/03/04/react-native-survey-shows-rocky-path-for-new-architecture" target="_blank">State of React Native survey coverage from DevClass</a>, 20% of the 3,501 respondents said their apps have over 100,000 users, up from 14% the previous year. Teams are shipping large audiences on it.</p>

<p>So the useful question is not "is React Native fast?" It is "does my app have heavy animation, media processing, or long lists that need deliberate engineering?" The sections below help you answer that for your own product.</p>
</section>

<section id="section2">
<h2 class="heading55px darkpurple">What the New Architecture Changed</h2>
<p>The biggest structural change in recent years is the removal of the asynchronous bridge. Under the old design, every call between JavaScript and native code was serialized, queued, and deserialized. The React Native team's post on <a href="https://reactnative.dev/blog/2024/10/23/the-new-architecture-is-here" target="_blank">the New Architecture arriving in 0.76</a> attributes the difficulty of hitting a consistent 60+ FPS on the old bridge to that serialization overhead. With JSI, JavaScript can call native code synchronously and hold direct references to native objects.</p>

<h3>From default to mandatory</h3>
<p>Version 0.76 (October 2024) turned the New Architecture on by default. It launched with 850+ compatible libraries, including every library with more than 200K weekly downloads. Then <a href="https://reactnative.dev/blog/2025/10/08/react-native-0.82" target="_blank">React Native 0.82 in October 2025</a> became the first release that runs entirely on it, and disabling the flags is simply ignored.</p>

<p>Cleanup carries a small payoff. In the <a href="https://reactnative.dev/blog/2025/12/10/react-native-0.83" target="_blank">0.83 release post</a>, an experimental flag that strips legacy architecture code cut build time from 73.0 s to 58.2 s and app size from 51.2 MB to 48.2 MB in a fresh app with no dependencies.</p>

<h3>The architecture is not a speed button</h3>
<p>Here is the part many summaries skip. <a href="https://www.callstack.com/events/react-and-react-native-the-year-kick-off" target="_blank">Callstack's 2026 outlook</a> argues that the New Architecture does not improve performance by itself. Real gains come from what it enables: concurrent rendering, worklets, GPU-based solutions, and finer control over threading. Callstack also warns that delaying migration means losing access to modern libraries such as Reanimated and Nitro-based modules.</p>

<p>For a founder, the takeaway is practical. If a vendor promises that "the new architecture makes your app faster," ask which libraries and patterns they plan to use on top of it.</p>
</section>

<section id="section3">
<h2 class="heading55px darkpurple">Hermes V1: Real Numbers, Modest Gains</h2>
<p>Hermes is the JavaScript engine that runs your code, and <a href="https://reactnative.dev/blog/2026/02/11/react-native-0.84" target="_blank">React Native 0.84 (February 11, 2026)</a> made Hermes V1 the default on both iOS and Android. It was an experimental opt-in in 0.82. Apps already on Hermes, which has been the default since 0.70, need no migration or config changes. If you need to opt out, you can use the hermes-compiler override or set hermesV1Enabled=false.</p>

<p>The 0.84 post says Hermes V1 delivers "improved execution speed and reduced memory usage," but it publishes no benchmark numbers. The only measured data comes from the earlier experimental phase. In the <a href="https://reactnative.dev/blog/2025/10/08/react-native-0.82" target="_blank">0.82 announcement</a>, testing on Expensify showed:</p>

<ul class="list">
<li><strong>Android, low-end device:</strong> bundle load 3.2% faster and total time to interactive (TTI) 7.6% faster.</li>
<li><strong>iOS:</strong> bundle load 9% faster and TTI 2.5% faster.</li>
</ul>

<p>The team is careful to say gains "strongly depend on the details of your apps," and that Hermes still has no JIT compiler. Treat Hermes V1 as a free, low-risk improvement, not a reason to postpone optimization work. A single-digit startup gain will not rescue a screen that re-renders too often.</p>

<p>One more detail from the release notes is worth a calendar reminder. <a href="https://reactnative.dev/blog/2026/06/11/react-native-0.86" target="_blank">React Native 0.86</a> is now the latest stable version, and 0.83.x is unsupported. If your app sits on an older release, upgrade planning belongs on your 2026 roadmap alongside features.</p>
</section>

<section id="section4">
<h2 class="heading55px darkpurple">Where the Big Wins Actually Come From</h2>
<p>Framework releases give you percentages in the single digits. App-level work gives you far more. The clearest public example is Shopify. In its engineering write-up, <a href="https://shopify.engineering/improving-shopify-app-s-performance" target="_blank">Improving Shopify App's Performance</a>, the team started with a P75 screen load of roughly 1,400 ms and an app launch around 4 seconds. Their targets were under 500 ms and 2 seconds.</p>

<p>The result: P75 launch time improved 44% and P75 screen load time dropped 59%. Two specific changes stand out. Enabling <strong>inlineRequires</strong> improved launch time by 17%, and default state batching improved screen load by 15% on average. Shopify also calls performance "a continuous process," which is the right mindset to adopt.</p>

<h3>Ship the bundle uncompressed on Android</h3>
<p>Discord offers a smaller but instructive case. According to the <a href="https://reactnative.dev/blog/2025/04/08/react-native-0.79" target="_blank">React Native 0.79 release post</a>, Margelo measured a 400 ms (12%) TTI reduction on the Discord app by shipping the JavaScript bundle uncompressed, tested on a Samsung A14. The tradeoff is more on-device storage, although download size is unaffected. The same release made Metro's first start typically over 3x faster through deferred hashing.</p>

<p>Notice the pattern. None of these wins came from rewriting in another language. They came from measuring, picking a target, and changing one thing at a time. That is a process you can budget for, and it is far cheaper than a rewrite.</p>
</section>

<section id="section5">
<h2 class="heading55px darkpurple">FlashList vs FlatList: Fixing Slow Lists</h2>
<p>Long lists are the most common source of jank in business apps: order histories, product grids, chat threads. The built-in FlatList works for modest data. Once rows get complex, the official docs point to alternatives. The <a href="https://reactnative.dev/docs/performance" target="_blank">performance overview</a> suggests FlashList and Legend List as replacements for FlatList.</p>

<p>FlashList comes from Shopify. Its engineering team reports in the <a href="https://shopify.engineering/flashlist-v2" target="_blank">FlashList v2 announcement</a> that the library passed 2 million monthly downloads and powers thousands of lists in Shopify's mobile app. Version 2 was rewritten from the ground up for the New Architecture, no longer needs item size estimates, and shows up to 50% reduced blank area while scrolling versus v1 on Shopify's own benchmarks.</p>

<p>A reasonable approach to the choice:</p>

<ul class="list">
<li><strong>Keep FlatList</strong> for short or simple lists where profiling shows no problem. Swapping libraries without evidence just adds a dependency.</li>
<li><strong>Move to FlashList v2</strong> when you see blank areas during fast scrolling, heavy row components, or thousands of items.</li>
<li><strong>Test in a release build</strong> before deciding. Scrolling that looks poor in a debug build can be fine in production.</li>
</ul>

<p>Also remember that "up to 50%" is a vendor benchmark on specific lists, not a guarantee for yours. Measure your own screen before and after.</p>
</section>

<section id="section6">
<h2 class="heading55px darkpurple">Animations and the 60 FPS Budget</h2>
<p>Animation is where React Native performance in 2026 is changing fastest. The docs warn that Animated runs on the JavaScript thread unless you set <strong>useNativeDriver: true</strong>. That single flag decides whether a busy JS thread makes your animation stutter.</p>

<p>Recent releases push this further. <a href="https://reactnative.dev/blog/2026/04/07/react-native-0.85" target="_blank">React Native 0.85 (April 7, 2026)</a> introduced an experimental Shared Animation Backend for Animated and Reanimated, built with Software Mansion. Animated can now animate layout properties such as Flexbox and position with the native driver. The post gives no benchmark numbers, so treat it as a direction of travel and not yet a measured win. It also requires Node 20.19.4 or newer.</p>

<p>The following release fixed a visible bug. According to the <a href="https://reactnative.dev/blog/2026/06/11/react-native-0.86" target="_blank">0.86 notes</a>, a mounting-layer sync issue made animated views flicker back to their pre-animation values. 0.86 has no user-facing breaking changes, which makes the upgrade low-risk.</p>

<h3>Do not judge animation in a debug build</h3>
<p>One data point from the 0.82 post deserves attention. In the team's animation sample, a debugOptimized Android build ran at about 60 FPS, while the plain debug build ran at about 20 FPS. If your QA team reports a choppy app, check which build they are holding before opening a ticket.</p>

<p>If your product is animation-heavy, such as gesture-driven interfaces, charts that update live, or custom transitions, plan a prototype of the hardest screen in the first two weeks. It is the cheapest way to learn whether you are in comfortable territory.</p>
</section>

<section id="section7">
<h2 class="heading55px darkpurple">React Native Performance Profiling That Works</h2>
<p>Teams guess at bottlenecks far more often than they measure them. The tooling now makes guessing unnecessary. The <a href="https://reactnative.dev/blog/2025/12/10/react-native-0.83" target="_blank">0.83 release</a> added a Performance panel to DevTools that shows JavaScript execution, React tracks, network events, and User Timings in one timeline. That means you can see why a tap took 300 ms without stitching together three tools.</p>

<p>The same release stabilized the Web Performance APIs: PerformanceObserver, performance.mark and measure, Long Tasks, and Event Timing. They work in production builds, so you can collect real-world metrics from actual users and not only from your own device. In 0.86, event timing now defaults its durationThreshold to 104 ms to follow the W3C spec, so expect slightly different output than older versions gave.</p>

<p>A short checklist keeps profiling honest:</p>

<ul class="list">
<li><strong>Always profile a release build.</strong> The docs say JavaScript performance "suffers greatly" in dev mode.</li>
<li><strong>Remove stray console.log calls.</strong> The docs note they can bottleneck the JS thread in bundled apps.</li>
<li><strong>Set a numeric budget per screen</strong>, such as the 16.67 ms frame budget or a launch target like Shopify's 2 seconds, then track it every release.</li>
<li><strong>Collect field data</strong> with the Web Performance APIs so you learn about slow devices before reviews do.</li>
</ul>

<p>Do this early and performance stops being a launch-week scramble.</p>
</section>

<section id="section8">
<h2 class="heading55px darkpurple">When Native Code or Another Stack Is the Better Call</h2>
<p>React Native is not the answer to every brief. Consider native Swift or Kotlin when the product's core value is something the JavaScript layer will fight against: real-time audio or video processing, custom GPU rendering, or deep platform features that ship on day one of an OS release. You can still use React Native for the rest of the app and write those modules natively, since the New Architecture makes that boundary cheaper to cross.</p>

<p>Callstack notes that Nitro modules reduce JS-to-native overhead for performance-critical paths, which narrows the set of cases where a full native rewrite is justified. Games are a separate category entirely, and a game engine is the right tool there.</p>

<p>We are deliberately not claiming a speed ranking against other cross-platform frameworks. No independent benchmark we could verify supports a clean winner, and your own app's workload matters more than any chart. The right comparison is a prototype of your hardest screen in each candidate, measured on a low-end Android phone.</p>

<p>If you are unsure whether your app's performance needs fit React Native, <a href="https://appverra.co/services/react-native-app-development" target="_blank">AppVerra's React Native developers</a> can profile your build and give you a straight answer in a 30-minute call.</p>
</section>

<section id="section9">
<h2 class="heading55px darkpurple">FAQs on React Native Performance in 2026</h2>
<p><strong>Q: Is React Native fast enough for production apps in 2026?</strong><br>Yes for most business apps. Shopify cut P75 launch time by 44% and screen load time by 59%, and Discord and Expensify ship it at scale. Animation-heavy and media-heavy apps need an early prototype.</p>

<p><strong>Q: What does the New Architecture change for React Native performance?</strong><br>It removes the async bridge so JavaScript and native code can talk synchronously through JSI. Callstack stresses that it is not a speed boost on its own. The gains come from libraries and patterns built on top of it.</p>

<p><strong>Q: Is Hermes V1 faster than the old Hermes engine?</strong><br>Modestly. On Expensify, experimental Hermes V1 improved TTI by 7.6% on low-end Android and 2.5% on iOS. The React Native team says results depend heavily on your app.</p>

<p><strong>Q: How do I fix slow lists in React Native?</strong><br>Profile in a release build first, then consider FlashList v2, which Shopify reports shows up to 50% less blank area while scrolling than v1. Keep rows light and avoid unnecessary re-renders.</p>

<p><strong>Q: When should I choose native code over React Native for performance?</strong><br>Choose native when the core feature is real-time media processing, custom GPU work, or immediate access to new OS capabilities. For everything else, write the hot path as a native module and keep the rest in React Native.</p>
</section>

<section id="section10">
<h2 class="heading55px darkpurple">Final Thoughts</h2>
<p>The framework has done its part. A single architecture, a faster default engine, and real profiling tools mean the remaining performance work is mostly yours: set budgets, test in release builds, and fix the screens that matter. The biggest public improvements, like Shopify's, came from steady measurement and not from a magic release.</p>

<p>If you want a second pair of eyes on an existing app or a new build plan, start with a prototype of your hardest screen and a clear performance target. Teams that do that early rarely face a painful rewrite later.</p>
</section>

<section id="section11">
<h2 class="heading55px darkpurple">Sources</h2>
<ul class="ul_list">
<li><a href="https://reactnative.dev/blog/2026/06/11/react-native-0.86" target="_blank">React Native 0.86 release post</a></li>
<li><a href="https://reactnative.dev/blog/2026/04/07/react-native-0.85" target="_blank">React Native 0.85 release post</a></li>
<li><a href="https://reactnative.dev/blog/2026/02/11/react-native-0.84" target="_blank">React Native 0.84 release post</a></li>
<li><a href="https://reactnative.dev/blog/2025/12/10/react-native-0.83" target="_blank">React Native 0.83 release post</a></li>
<li><a href="https://reactnative.dev/blog/2025/10/08/react-native-0.82" target="_blank">React Native 0.82 release post</a></li>
<li><a href="https://reactnative.dev/blog/2024/10/23/the-new-architecture-is-here" target="_blank">The New Architecture is here (React Native blog)</a></li>
<li><a href="https://reactnative.dev/docs/performance" target="_blank">React Native Performance Overview</a></li>
<li><a href="https://reactnative.dev/blog/2025/04/08/react-native-0.79" target="_blank">React Native 0.79 release post</a></li>
<li><a href="https://shopify.engineering/flashlist-v2" target="_blank">Shopify Engineering: FlashList v2</a></li>
<li><a href="https://shopify.engineering/improving-shopify-app-s-performance" target="_blank">Shopify Engineering: Improving Shopify App's Performance</a></li>
<li><a href="https://www.callstack.com/events/react-and-react-native-the-year-kick-off" target="_blank">Callstack: React and React Native in 2026</a></li>
<li><a href="https://devclass.com/2025/03/04/react-native-survey-shows-rocky-path-for-new-architecture" target="_blank">DevClass: React Native survey</a></li>
</ul>
</section>
