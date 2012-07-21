# CakePHP Cart Plugin #

http://github.com/burzum/cart

A CakePHP shopping cart plugin with an interface for different payment providers

The cart plugin is a stand alone cart only plugin, no payment processors are included you'll have to write them or get them from somewhere else.

I'm looking for help to complete this plugin.

If you're interested please send me a message on github and fork it.

## Requirements

 * CakePHP 2.x
 * CakeDC Search Plugin for CakePHP https://github.com/cakedc/search

## Parts of the Plugin explained 

### Cart Manager Component

The Cart Manager is a component thought to capture post and get requests to a specified action, by default "buy" and add the result of this to the cart.

The Session, Cookie and Database Storage of the Cart Manager is pretty much decoupled.

Planed features

 * Add any record from any model as item to the cart
 * Tax Rules
 * Discount Rules
 * Downloadable/virtual item handling
 * 

## Setup

TBD

## Support

This plugin is still in early development, feel free to help fixing and contributing to it, there is no form of bug or feature support yet.