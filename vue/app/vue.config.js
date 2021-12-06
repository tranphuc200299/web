module.exports = {
    publicPath: process.env.NODE_ENV === 'production' ? process.env.VUE_APP_ASSET_URL : process.env.VUE_APP_WEB_URL,
    productionSourceMap: !! process.env.NODE_ENV === 'production'
}