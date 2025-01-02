@extends('layouts.blog')

@section('content')
<main>
    <div class="container mx-auto p-4 leading-loose">
        <h1 class="text-4xl font-bold text-center mb-8">Privacy Policy</h1>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <p class="text-lg mb-4">Your privacy is important to us. This Privacy Policy explains how we collect, use, and protect your information when you use the Wordcraft platform.</p>

            <h2 class="text-2xl font-semibold mt-6">1. Information We Collect</h2>
            <p class="mb-4">
                We collect the following types of information when you use Wordcraft:
            </p>
            <ul class="list-disc pl-8 mb-4">
                <li>Personal Information: Name, email address, and other details you provide during registration or communication.</li>
                <li>Usage Data: Information about how you interact with the platform, such as pages visited, time spent, and actions taken.</li>
                <li>Cookies: We use cookies to enhance user experience, track activity, and personalize content.</li>
            </ul>

            <h2 class="text-2xl font-semibold mt-6">2. How We Use Your Information</h2>
            <p class="mb-4">
                We use the information we collect to:
            </p>
            <ul class="list-disc pl-8 mb-4">
                <li>Provide and improve our services.</li>
                <li>Communicate with you regarding your account and updates.</li>
                <li>Analyze usage patterns to enhance user experience and ensure the platform’s functionality.</li>
            </ul>

            <h2 class="text-2xl font-semibold mt-6">3. Data Protection</h2>
            <p class="mb-4">
                We employ reasonable security measures to protect your personal information from unauthorized access, loss, or misuse. However, no method of transmission over the internet or electronic storage is 100% secure, and we cannot guarantee absolute security.
            </p>

            <h2 class="text-2xl font-semibold mt-6">4. Sharing of Information</h2>
            <p class="mb-4">
                We do not sell, rent, or trade your personal information to third parties. We may share information with trusted service providers who help operate our platform or with authorities if required by law.
            </p>

            <h2 class="text-2xl font-semibold mt-6">5. Your Rights</h2>
            <p class="mb-4">
                You have the right to:
            </p>
            <ul class="list-disc pl-8 mb-4">
                <li>Access, update, or delete your personal information.</li>
                <li>Request a copy of the data we hold about you.</li>
                <li>Opt-out of marketing communications at any time.</li>
            </ul>

            <h2 class="text-2xl font-semibold mt-6">6. Changes to This Privacy Policy</h2>
            <p class="mb-4">
                We may update this Privacy Policy periodically. We will notify you of significant changes by posting the updated policy on this page with a new effective date.
            </p>

            {{-- <h2 class="text-2xl font-semibold mt-6">7. Contact Us</h2>
            <p>
                If you have any questions or concerns about this Privacy Policy, please contact us at <a href="mailto:contact@wordcraft.com" class="text-blue-600">contact@wordcraft.com</a>.
            </p> --}}
        </div>
    </div>
</main>

@endsection
