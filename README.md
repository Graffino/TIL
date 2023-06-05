
# Today I Learned (TIL)

## About

"Today I Learned" is a microblogging platform built with PHP and Laravel. Its main aim is to enable developers, even those who aren't writers by trade, to contribute to both internal organizational knowledge and broader community learning. This platform allows developers to share bite-sized pieces of knowledge, code snippets, "aha" moments, or fun findings from their daily discoveries in the coding journey.

The project was originally conceived as a personal effort by Nick Ciolpan to learn Elixir and Phoenix framework by rewriting Hashrocket's Elixir version of TIL into something more familiar at that time: Laravel. This project came to life in 2016 and has been evolving since.

## Technology Stack

- PHP
- Laravel

## Installation and Usage

Please ensure you have PHP and Laravel installed on your system before proceeding.

**Step 1:** Clone this repository
```sh
git clone https://github.com/graffino/til.git
```
**Step 2:** Move to the cloned directory
```sh
cd til
```
**Step 3:** Install the required dependencies
```sh
composer install
```
**Step 4:** Set up your environment variables in `.env` file

**Step 5:** Migrate the database
```sh
php artisan migrate
```
**Step 6:** Run the application
```sh
php artisan serve
```
If you prefer to use Sail, you can run the application with `sail up`.

### Advanced Setup
1. Configure the Socket.IO server as a Pusher replacement. Please reference their documentation and update the Pusher JS SDK in `bootstrap.js` accordingly. Alternatively, revert to Pusher if the pricing works for you.
2. Set up Redis and run Horizon using a supervisor of your choice.
3. At the moment, authentication is available through Google. You need to provide the email domain name in the `.env` file. In the future, this will be improved to work with Google OAuth policies. If interested, the old way of authenticating via GitHub can also be provided.

You should now be able to access the application at `localhost:8000` on your browser.

## Contributing

I encourage you to clone this and spin your own. 

## Acknowledgements

This project was inspired by Hashrocket's version of TIL written in Elixir. Many thanks to the developer community for sharing their knowledge and resources.

## License

This project is licensed under [MIT license](LICENSE).

---

You may need to add or modify steps based on the actual requirements and setup of your project.
