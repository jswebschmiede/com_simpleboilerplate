# Simpleboilerplate - Joomla Component

## Description

Simpleboilerplate is a base component for Joomla, serving as a starting point for developing custom components. It provides a pre-configured structure and integrates modern development tools for efficient Joomla extension development.

## Features

-   Pre-configured Webpack setup for efficient asset management
-   Integration of Tailwind CSS for modern, responsive styling (optional)
-   Automated build processes for development and production
-   Progress display during the build process
-   Automatic creation of ZIP archives for easy installation
-   Automatic copying of files to your Joomla installation
-   Composer support (if needed uncomment the autoload.php in the services/provider.php file and the dependencies folder in simpleboilerplate.xml)
-   Scoped dependencies
-   No Category support (if needed, look at https://github.com/jswebschmiede/com_boilerplate)

## Prerequisites

-   Node.js (version 21.5.0 or higher)
-   pnpm (can be installed globally with `npm install -g pnpm`)
-   Joomla 5.x or higher (tested with Joomla 5.0)
-   PHP 8.1 or higher (tested with PHP 8.3)
-   Make (optional, but recommended). If not installed on Debian/Ubuntu use `sudo apt-get update && sudo apt-get install make`.
-   Composer (optional, but recommended). If not installed on Debian/Ubuntu use `sudo apt-get update && sudo apt-get install composer`.
-   PHP-Scoper (optional, but recommended). If not installed use `composer global require humbug/php-scoper`. if it is installed, try `php-scoper -V` to check the version.
    more information about PHP-Scoper: https://github.com/humbug/php-scoper or https://www.dionysopoulos.me/book/advice-composer.html

## Installation

1. Clone the repository:

    ```
    git clone https://github.com/jswebschmiede/com_simpleboilerplate.git
    ```

2. Navigate to the project directory:

    ```
    cd com_simpleboilerplate
    ```

3. Install dependencies:

    ```
    pnpm install
    ```

4. Install Composer dependencies (if needed uncomment the autoload.php in the services/provider.php file and the dependencies folder in simpleboilerplate.xml):

    ```
    composer install (or make install)
    ```

5. Scope dependencies: (only needed if you want to use scoped dependencies)

    ```
    make scope
    ```

6. Dump autoload: (only needed if you want to use scoped dependencies)

    ```
    make dump
    ```

7. Remove vendor folder: (only needed if you want to use scoped dependencies)

    ```
    make delvendor
    ```

## Usage

### Make Commands

The Makefile is used to install the dependencies and scope the dependencies.

```
make all # install dependencies, scope dependencies, dump autoload and remove vendor folderq
make clean # remove vendor folder and the scoped dependencies folder
make dump # dump the autoload
make install # install the dependencies
make scope # scope the dependencies
make delvendor # delete the vendor folder
make deldependencies # delete the scoped dependencies folder
```

### Development Mode

To work in development mode and benefit from automatic reloading and copying the files to your Joomla installation:

-   install the component in Joomla (see Production Mode)
-   configure the `webpack.config.js` file with the path to your Joomla installation (default is `../../joomla`)
-   folder structure should look like this. You can change the names of the folders, important is only the structur itself.

```
joomla_dev/
    - joomla/
    - joomla_components/
        - com_simpleboilerplate/
```

-   start the development server:

```
pnpm run dev
```

### Production Mode

To create a production-ready version of your component:

```
pnpm run build
```

This creates an optimized version of the component and packages it into a ZIP file for installation in Joomla.

## Project Structure

-   `src/`: Component source code
    -   `administrator/`: Administrator area of the component
    -   `components/`: Site area of the component
    -   `media/`: Assets such as JavaScript and CSS
-   `dist/`: Compiled and optimized files (after build)
-   `webpack.config.js`: Webpack configuration
-   `tailwind.config.js`: Tailwind CSS configuration
-   `composer.json`: Composer configuration
-   `package.json`: Project dependencies and scripts
-   `makefile`: Makefile
-   `scoper.inc.php`: Scoper configuration

## Customization

You can customize the component by editing the files in the `src/` directory. The main customization points are:

-   replace all occurences of `com_simpleboilerplate` with your component name, don't forget to change the name in the `package.json` file, the `webpack.config.js` file and the `composer.json` file too
-   replace all occurences of `Simpleboilerplate` and `simpleboilerplate` with your component name

## Contributing

Contributions are welcome! Please create a pull request or open an issue for suggestions and bug reports.

## License

MIT License; see LICENSE.txt
