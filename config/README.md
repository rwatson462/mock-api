# Directory: `config`

In this directory is the user-configured part of this service.

The `responses` directory holds all your hard-coded responses that the service
can return for the routes you'll configure in the `routes` directory.  As you
can see from the demos included, any file can be used just like a standard
website can return.

The `routes` directory contains the definitions for the routes you'll create.
The configuration uses INI files.  This is generally considered a bit "old
fashioned" but it's simple and works just fine for this service. Each file can
contain many routes, or you can use 1 route per file.  Each heading is assumed
to be a route name, and the settings underneath the heading will make up the
Route definition.