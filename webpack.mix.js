let TEMPLATE = process.env.VIEW_TEMPLATE;
if (!TEMPLATE) {
    TEMPLATE = 'base';
}

require('./resources/assets/_template/' + TEMPLATE + '/mix');