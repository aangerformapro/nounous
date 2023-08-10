/**
 * sass + postcss are not run anymore but i will keep that file there if needed as
 * rollup is a mjs module and there are some bugs when importing cjs modules from a mjs
 * that file will serve as proxy to load plugins in a commonjs environment
 */


// function is being used there to load the same plugins in rollup-plugin-postcss
function loadPlugins(prod)
{
    return [
        // put your plugin configuration there

        require("postcss-import")(),
        !prod && require('postcss-combine-media-query')(),
        require('postcss-preset-env')({
            autoprefixer: {
                cascade: false,
            },
            features: {
                'custom-properties': true,
            },
        }),
        !!prod && require('cssnano')({ preset: 'default' })
    ];
};


function postcss(ctx) 
{

    return {
        map: ctx.options.map,
        parser: ctx.options.parser,
        plugins: loadPlugins(ctx.env === 'production'),
    };
};


postcss.plugins = loadPlugins;


module.exports = postcss;