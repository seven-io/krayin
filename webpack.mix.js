let mix = require('laravel-mix')
if (mix === undefined) mix = require('laravel-mix').mix

require('laravel-mix-merge-manifest')

const inProduction = mix.inProduction()

const publicPath = inProduction
    ? 'publishable/assets'
    : '../../../public/vendor/sms77/assets'

mix.setPublicPath(publicPath).mergeManifest()
mix.disableNotifications()

const assetsPath = `${__dirname}/src/Resources/assets/`

mix.js(assetsPath + 'js/admin.js', 'js/admin.js')
    .copy(assetsPath + 'images', `${publicPath}/images`)
    .sass(assetsPath + 'sass/admin.scss', 'css/admin.css')
    .options({processCssUrls: false})
    .vue()

mix.webpackConfig({
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.runtime.js'
        }
    }
})

if (inProduction) mix.version()
else mix.sourceMaps()