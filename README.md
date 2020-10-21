# Cleaver

[![Current Version](https://img.shields.io/packagist/v/aschmelyun/cleaver.svg?style=flat-square)](https://packagist.org/packages/aschmelyun/cleaver)
![License](https://img.shields.io/github/license/aschmelyun/cleaver.svg?style=flat-square)
[![Build Status](https://img.shields.io/travis/aschmelyun/cleaver/master.svg?style=flat-square)](https://travis-ci.org/aschmelyun/cleaver)
[![Total Downloads](https://img.shields.io/packagist/dt/aschmelyun/cleaver.svg?style=flat-square)](https://packagist.org/packages/aschmelyun/cleaver)

:fire: A blazing-fast static site generator that uses Laravel's Blade templating engine and leverages JSON or Markdown files for super-extensible content.

```bash
composer create-project aschmelyun/cleaver your-site-name
```

## Requirements
- PHP 7.2.5 or higher
- Fairly recent versions of node + npm 

## Installation

After creating your project with Composer, cd inside your project's root directory and install node dependencies:

```bash
npm install
```

From there you can build the site using the included demo content, which outputs to a `dist/` folder in your project root:

```bash
npm run dev
```

## Modifying your assets

Cleaver uses SCSS for styling, and there's a basic skeleton structure set up in the `resources/assets/sass` directory. Tailwind is imported by default so you can jump right in to rapid development and prototyping.

There's a bootstrapped JavaScript file that imports lodash, jQuery, and Vue dependencies through npm to use with your project. That can be modified by editing the `resources/assets/js/app.js` file.

## Building the site

To compile the SCSS/JS assets and build the static site files, you can run `npm run dev` from the root. Additionally, using `npm run watch` starts up a local node server that you can use to view your compiled project, and will watch the entire `resources/` directory for changes to any assets, views, or content files.

If you would like to build your site without compiling the assets, run the `php cleaver build` command from the project root.

## Commands and arguments

If you build the site by calling `php cleaver build` directly, here's a list of the current commands and accompanying arguments you can use:

- `php cleaver build {page}` builds the current site, rendering your content in the `resources/content` directory and outputting HTML organized in a directory tree to `/dist`. You can choose to render a single page or just a specific path in your content by including a `page` argument. (e.g. `php cleaver build posts/my-cool-post.md`)

## Publishing your site

Once you're ready to publish your site, simply run the command:

```bash
npm run production
```

Which will minify your assets and build the site again with the new versioned files.

You can then publish your entire project to a host of your choice as long as the web root is pointed to the `/dist` folder. Additionally, you're free to just publish the built files in the dist folder by themselves.

## Roadmap
Cleaver is still very much in development, and while it's designed to remain as simple as possible there's a few features that could make for a better overall experience. Here's what's on the path ahead:

- [x] Ability to use folders in content directory
- [x] Add collection containing all content into each view
- [x] A better cli interface and style during site builds
- [x] Ability to add in and use HTML in JSON content files
- [ ] More detailed build errors if something goes wrong
- [ ] Create and import site scaffolds from the command line

## Contact Info

Have an issue? Submit it here! Want to get in touch or recommend a feature? Feel free to reach out to me on [Twitter](https://twitter.com/aschmelyun) for any other questions or comments.

## License

The MIT License (MIT). See [LICENSE.md](https://github.com/aschmelyun/cleaver/blob/master/LICENSE.md) for more details.