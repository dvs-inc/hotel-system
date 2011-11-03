This directory contains all the page classes.

THIS IS IMPORTANT: READ THIS CAREFULLY!

A page called X will ONLY be found and used if it is in it's own file in this folder called PageX.php, defined as a class PageX, and that class inherits from PageBase (and hence implements a method called runPage() )

Any deviation from that, and the loader won't find it for you.

Your page will then be available at /index.php/X

Don't put any other files in this folder other than those which are meant to be page definitions.
