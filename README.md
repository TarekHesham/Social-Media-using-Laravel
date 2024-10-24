<p align="center">
  <a href="https://iti.gov.eg/" target="_blank" rel="noopener noreferrer">
    <img width="150" src="https://shamra-academia.com/uploads/publishers/logoc1ee0a1961b28b92869f371af51313da.png" alt="ITI Logo">
  </a>
</p>

# Laravel Social Media

This project was generated with [Laravel](https://laravel.com/docs) version 11.

## Demo

<div align="center">

![LoginPage](./demo/LoginPage.png)
![HomePage](./demo/HomePage.png)
![EditPost](./demo/EditPost.png)
![Post1](./demo/Post1.png)
![Post2](./demo/Post2.png)
![ShowPosts](./demo/ShowPosts.png)
![PostsInTrash](./demo/PostsInTrash.png)
![TrashRestore](./demo/TrashRestore.png)

</div>

## Development server

Run `php artisan serve` for a dev server. Navigate to `http://127.0.0.1:8000/`. The api will automatically reload if you change any of the source files.

## Build
```bash
composer install # Composer will install all dependency resources

php artisan migrate:fresh --seed # Laravel will generate all tables and add data

npm install # Install all packages

npm run dev
php artisan serve # Run service on port 8000
```
- **Don't Forget to add your DB informations in `.env`**
