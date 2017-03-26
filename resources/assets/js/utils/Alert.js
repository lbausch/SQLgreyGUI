const Alert = {}

Alert.install = function (Vue) {
    Vue.prototype.$alertSuccess = function (text, options) {
        let default_options = {
            type: "success",
            title: "Success!",
            text: text,
            timer: 3000,
        }

        this.$swal(_.merge({}, default_options, options))
            .then(() => {
                //resolve()
            })
            .catch(() => {
                //reject()
            })
    }
}

export default Alert
