// rollup.config.js
import path from 'node:path';
import fs from 'node:fs';
import resolvePlugin from '@rollup/plugin-node-resolve';
import commonjsPlugin from '@rollup/plugin-commonjs';
import postcssPlugin from 'rollup-plugin-postcss';
import terserPlugin from '@rollup/plugin-terser';
// import sveltePlugin from 'rollup-plugin-svelte';
// import sveltePreprocess from 'svelte-preprocess';
import jsonPlugin from '@rollup/plugin-json';
import delPlugin from 'rollup-plugin-delete';
import nodePolyfillsPlugin from 'rollup-plugin-polyfill-node';
import postcss from './postcss.config.cjs';


const
    // if rollup is not watching we are in production environment
    prod = !process.env.ROLLUP_WATCH,
    // file extensions to scan for
    JS_EXTENSIONS = ['.js', '.mjs', '.cjs',],
    // output file extension
    OUTPUT_EXTENSION = '.js',
    // output css extension: overridet this to use a namespace before .css
    OUTPUT_CSS_EXTENSION = '.css',
    // ignore files matched with those patterns
    IGNORE_PATTERNS = [/^_/],

    dirs = {
        // indexes matches except if output has only one it will use it for all the inputs
        input: [
            //insert others there if needed
            'lib',

        ],
        output: [
            // your dist dir(s)
            'public/assets'
        ],
    },
    // if rollup used with -w, we trigger build when those folders are modified
    watchFolders = [
        ...dirs.input,
        // watch sass files
        'scss',
        // watch deps
        'modules'

    ].filter(x => fs.existsSync(x)),
    // Uncomment if using svelte
    // sveltePluginConfig = {
    //     preprocess: sveltePreprocess(),
    //     emitCss: true,
    //     compilerOptions: {
    //         // can use dev tools in browser
    //         dev: !prod,
    //         accessors: true,
    //         hydratable: true,
    //     }
    // },
    loadPlugins = ({
        name,
        // input,
        output,
    } = {}) =>
    {

        const
            plugins = [],
            // { dir: inputdir } = path.parse(input),
            { dir: outputdir } = path.parse(output);


        // to be executed first
        prod && plugins.push(
            // remove map files in production mode
            delPlugin({ targets: path.join(outputdir, '*.map') }),
        );
        // plugins available in prod and dev mode
        plugins.push(
            jsonPlugin(),
            // sveltePlugin(sveltePluginConfig),
            postcssPlugin({
                // load plugins from postcss.config.cjs
                plugins: postcss.plugins(prod),
                sourceMap: !prod,
                // prevents conflicting names with postcss
                extract: name + OUTPUT_CSS_EXTENSION,
            }),
            // import node_modules like nothing
            resolvePlugin({
                moduleDirectories: ['node_modules'],
                extensions: JS_EXTENSIONS,
                browser: true,
            }),
            // Convert CommonJS modules to ES6+
            commonjsPlugin(),
            // using node modules in browser
            nodePolyfillsPlugin(),
        );

        // minify js
        prod && plugins.push(terserPlugin());

        return plugins;
    },
    getFileList = (inputdir, outputdir) => fs.readdirSync(inputdir)
        // check files
        .filter(
            file =>
                // has one of js extensions
                JS_EXTENSIONS.some(ext => file.endsWith(ext))
                // file does not match an ignore pattern
                && !IGNORE_PATTERNS.some(pattern => pattern.test(file))
        )
        // return file infos
        .map(filename =>
        {
            const { name } = path.parse(filename);
            return {
                input: path.join(inputdir, filename),
                output: path.join(outputdir, name + OUTPUT_EXTENSION),
                name,
            };
        }),
    makeConfig = (fileList = []) => fileList.map(({
        name,
        input,
        output
    }) =>
    ({
        watch: {
            exclude: 'node_modules/**',
            include: watchFolders.map(x => path.join(x, '**')),
        },
        //prevents some build bugs with this
        //as we are building for browser
        context: 'globalThis',
        input,
        output: [
            //for umd we need that config (just uncomment)
            // {
            //     format: 'umd',
            //     sourcemap: !prod,
            //     file: path.parse(output).dir + '/' + name + '.umd' + OUTPUT_EXTENSION,
            //     name,
            //     exports: 'named',
            // },
            {
                format: 'es',
                sourcemap: !prod,
                file: output,
            }
        ],

        plugins: loadPlugins({ name, output, input }),
    }));



export default [].concat(...dirs.input.map(
    (inputdir, index) =>
        makeConfig(getFileList(inputdir, dirs.output[index] ?? dirs.output[0]))
));