# Upcloo Wordpress Plugin

UpCloo is a cloud based and fully hosted indexing engine that helps you to create incredible and automatic correlations between contents of your website.

## Highlights

This plugin is designed for provide a full access to UpCloo technology

## More info

You can use follow links:

 * [Developer pages](http://developer.upcloo.com/application/wordpress.html)
 * [Issues](https://github.com/upcloo/upcloo-wordpress-plugin/issues)

## Build and distribuite

For distribuite this WordPress plugin you have three options:

 * use an already compiled tree [Download area](/upcloo/upcloo-wordpress-plugin/downloads)
 * build the package by your self for generate a valid tree
 * copy ```wp-upcloo`` folder into your production env

If you copy all resource all system works fine without any improvements
or performance reduction. Only the natural package is quite verbose
respect a compiled one. That because the UpCloo have tests, packages
and all other development stuffs.

### Building library

Build is supported by Ant file "build.xml" and is very simple to use

Compile the project with ```ant```. If you want to clean your
project use ```ant clean```.

After compile process you have a new directory named ```dist``` that
have only necessary stuffs for WordPress. Now open this one and
you can copy the ```wp-upcloo``` folder directly into your ```wp-content/plugins``` .

### Contributors

In this section we want to list all people that help us to maintain and fix problems with this
plugin.

Thanks to:

 * @miziomon ([Mavida s.n.c.](http://www.mavida.com/))
  * WP messages and notifications improvement.
   * Contribution on release: 1.1.19
  * WP Plugin Update Central
   * Contribution on release: 1.2.9

