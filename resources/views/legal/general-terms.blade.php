@extends('layouts.blog')

@section('content')
<main>
    <div class="container mx-auto p-4 leading-loose">
        <h1 class="text-4xl font-bold text-center mb-8">Terms and Conditions of Use</h1>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <p class="text-lg mb-4">Please read these terms and conditions carefully before using the Wordcraft platform.</p>

            <h2 class="text-2xl font-semibold mt-6">1. Introduction</h2>
            <p class="mb-4">
                These Terms and Conditions govern your use of the Wordcraft platform, including all content, features, and services provided by Wordcraft. By accessing or using the platform, you agree to comply with these terms.
            </p>

            <h2 class="text-2xl font-semibold mt-6">2. User Responsibilities</h2>
            <p class="mb-4">
                You agree to use the platform responsibly, including respecting others' intellectual property, not engaging in harmful activities, and following all applicable laws and regulations.
            </p>

            <h2 class="text-2xl font-semibold mt-6">3. Privacy and Data Protection</h2>
            <p class="mb-4">
                We are committed to protecting your privacy. For more information on how we handle your personal data, please refer to our <a href="{{ route('legal.privacy-policy') }}" class="text-blue-600">Privacy Policy</a>.
            </p>

            <h2 class="text-2xl font-semibold mt-6">4. Limitation of Liability</h2>
            <p class="mb-4">
                Wordcraft is not liable for any damages resulting from the use of the platform, including but not limited to errors, disruptions, or loss of data.
            </p>

            <h2 class="text-2xl font-semibold mt-6">5. Modifications to the Terms</h2>
            <p class="mb-4">
                We reserve the right to modify these Terms and Conditions at any time. Any changes will be posted on this page with an updated effective date.
            </p>

            <h2 class="text-2xl font-semibold mt-6">6. Governing Law</h2>
            <p class="mb-4">
                These terms are governed by the laws of the jurisdiction in which Wordcraft operates.
            </p>

            {{-- <h2 class="text-2xl font-semibold mt-6">7. Contact Us</h2>
            <p>
                If you have any questions or concerns about these Terms and Conditions, please contact us at <a href="mailto:contact@wordcraft.com" class="text-blue-600">contact@wordcraft.com</a>.
            </p> --}}
        </div>
    </div>
</main>

@endsection
