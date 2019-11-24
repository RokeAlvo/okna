let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .sourceMaps();

mix.webpackConfig({
   resolve: {
      alias: {
         '@': path.resolve(__dirname, './resources/assets/js/'),
         '~': path.resolve(__dirname, './resources/assets/')
      },
   },
   module: {
      rules: [
         {
            test: /\.pug$/,
            loader: 'pug-plain-loader'
         },
         {
            test: /\.scss$/,
            use: [
               {
                  loader: 'sass-loader',
                  options: {
                     sourceMap: true,
                  }
               },
               {
                  loader: 'style-resources-loader',
                  options: {
                     patterns: [
                        path.resolve(__dirname, 'resources/assets/sass/_variables.scss')
                        // './path/from/context/to/scss/variables/*.scss',
                        // './path/from/context/to/scss/mixins/*.scss',
                     ]
                  }
               }
            ]
         }
      ]
   }
});

function addStyleResource(rule) {
   rule.use('style-resource')
      .loader('style-resources-loader')
      .options({
         patterns: [
            path.resolve(__dirname, './src/styles/imports.styl'),
         ],
      })
}