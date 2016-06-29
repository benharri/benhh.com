---
title: Heroku and Grav flat-file CMS
publish_date: 2016-06-24
image:
  src: /img/lighthouse.jpg
  alt: Marquette Lighthouse
---

## Deploying Grav on Heroku

When I started building a website (sparked by the purchase of my first personal domain name), I started looking into many different solutions to my web development process. 

I had already decided that I would use a free dyno on [Heroku](https://heroku.com) for hosting.

### Several systems came to mind:
+ [Django](https://djangoproject.com/)
    * Django's opinionated Model model seemed a bit much for a relatively static site
    * It would be a great learning experience in Python
+ [Vanilla PHP](https://php.net)
    * I have a lot of experience in vanilla PHP at my internship at [Northern Michigan University](http://nmu.edu) working in the Information Services department where I develop web applications for internal use.
    * I often find myself frustrated with PHP's quirkiness and wouldn't learn new material.
+ [Silex](https://silex.sensiolabs.com)
    * This is a new micro-framework built using bare components of the much larger [Symfony](https://symfony.com) framework.
    * I discovered Silex in [Heroku's PHP deployment guide](https://devcenter.heroku.com/articles/getting-started-with-php) where I noticed that it was small enough to not draw unneeded overhead and extensible enough for my website to grow as it needed.
    * This is the framework that I eventually decided to use for my site.

As I researched additional solutions, I came upon the world of the PHP CMS (Content Management System, for the uninitiated). Just the sheer number and variety of CMS is [terrifying](https://en.wikipedia.org/wiki/List_of_content_management_systems#PHP). 

The free tier for databases in Heroku felt lacking in peace of mind and ease of setup so I continued into the realm of the "flat-file" CMS.

I discovered [Grav](https://getgrav.org) purely by chance. Grav claims to be fast and extensible. I was enticed by the flashy admin interface replete with responsive UI and a gorgeous built-in Markdown editor for content creation.

After a bit of finicking with the configuration, I managed to deploy a Grav instance into a Heroku dyno (a rather annoying affair which involved deploying caches to Heroku and `mod_rewrite` rules in `.htaccess` -- perhaps a topic for a future blog post).

The tricky part came when I brought the [Admin Plugin](https://github.com/getgrav/grav-plugin-admin) into the picture. Without the Admin Plugin, you need to directly change the configurations and add content from the filesystem and then deploy that to the web. You are able, however, to use PHP's built-in development webserver (`php -S localhost:9000`) to test your changes. 