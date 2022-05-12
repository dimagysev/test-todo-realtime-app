window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import 'materialize-css/dist/js/materialize.min';

window.io = require('socket.io-client');

