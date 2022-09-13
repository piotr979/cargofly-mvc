# cargofly-mvc

This is a little bit improved code of my MVC pattern app. It has some basic html template for demonstration purposes.

FIXTURES:

To launch fixtures following line must be run in App.php:


FORMS:
Creating new input elements is a bit similar to Symfony:

$fixtureLauncher = new FixtureLauncher($this->db->getConnection());

FLEET PAGE:
Displays paginated list of all named planes available. Models are taken from aeroplane (another) list. Results can be sorted by columns and filtered by search form.

