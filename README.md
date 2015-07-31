#SlideViewer
Web viewer for virtual slides based on Symfony2.

This work is designed and developed as Master Thesis in Computer Science under the supervision of prof. V. Della Mea, University of Udine, Italy, inside the Marie Curie AIDPATH Project.

_The implementation is at early stages._

#Installation
Use `composer update` and `bower update` to install needed bundles and files.

Put a folder named `slides` under `app/resources` and put inside of it virtual slides you want to view.

This software requires [openslide.so](https://github.com/BlakSneil/Openslide-PHP-Bindings/blob/master/openslide.so) PHP module to be installed into your PHP system.

Use `php app/console doctrine:fixtures:load` to load some test information. This required you add three of [this SVS slide samples](http://openslide.cs.cmu.edu/download/openslide-testdata/Aperio/) to the slides folder.
