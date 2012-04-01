# Upcloo Wordpress Plugin

UpCloo is a cloud based and fully hosted indexing engine that helps you to create incredible and automatic correlations between contents of your website.

## Highlights

This plugin is designed for provide a full access to UpCloo technology

## More info

You can use follow links:

 * [Wiki pages](https://github.com/corley/upcloo-wordpress-plugin/wiki)
 * [Issues](https://github.com/corley/upcloo-wordpress-plugin/issues)
 
## Build and distribuite

For distribuite this WordPress plugin you have three options:

 * use an already compiled tree
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
you can copy the ```wp-upcloo``` folder directly into your 
```wp-content/plugins```.

