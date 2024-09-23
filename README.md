# Wordcraft
Wordcraft is a simple web application built using Vue.js, Laravel, and Inertia.js. It allows users to add words or sentences and leverage AI to automatically fill in useful information such as antonyms, synonyms, related words, examples, word type, and more. Additionally, the application provides tag-based organization, enabling easy retrieval of words based on tags or word text.

## Features
- AI-Powered Word Information: Automatically generate details like antonyms, synonyms, examples, and more for each word or sentence.
- Tag System: Add multiple tags to each word, enabling easy filtering and search.
- Search by Word or Tag: Retrieve words easily by searching for tags or specific word text.
- Dynamic UI: Built using Vue.js and Inertia.js for a responsive, modern user experience.
- RESTful API: Backend powered by Laravel, with a robust API for managing words and tags.

## Technologies Used
- Frontend: Vue.js, Tailwind CSS, Inertia.js
- Backend: Laravel 11
- AI: Integrated AI services to fetch word-related data
- Icons: FontAwesome for UI icons
- Database: MySQL for data storage

## Installation
### Prerequisites
Ensure you have the following installed on your machine
- PHP >= 8.2
- Composer
- Node.js 20.10.0 & NPM
- MySQL (or another supported database)

### Step-by-Step Setup
1. Clone the Repository:

```bash
git clone https://github.com/Timmyway/wordcraft.git
cd wordcraft
```

2. Install Backend Dependencies:
```bash
composer install
```

3. Install Frontend Dependencies:
```bash
npm install
```

4. Set Up Environment:
Create a `.env` file by copying the `.env.example`:
```bash
cp .env.example .env
```
Then, set up your database connection and other environment variables in `.env`. You need to provide a Google Gemini API key.

5. Generate Application Key:
```bash
php artisan key:generate
```

6. Run Migrations:
Migrate the database to create necessary tables:
```bash
php artisan migrate
```

7. Build Frontend Assets:
```bash
npm run dev
```

8. Start the Application:
```bash
php artisan serve
```
The application will be running at http://localhost:8000.

9. Usage
- Adding Words: Add new words or sentences through the UI, and the AI will populate relevant information.
- Tagging System: Assign tags to words to easily categorize and filter them.
- Search: Use the search bar to find words either by their text or associated tags.

## Contributing
Contributions are welcome! If you'd like to contribute to Wordcraft, please follow these steps:

- Fork the repository.
- Create a new branch: git checkout -b feature-branch-name.
- Commit your changes: git commit -m 'Add new feature'.
- Push to the branch: git push origin feature-branch-name.
- Open a pull request.

## License
This project is licensed under the MIT License. See the LICENSE file for details.
