const Alert = {}

Alert.install = function (Vue) {
  Vue.prototype.$alertSuccess = function (text, options) {
    let defaultOptions = {
      type: 'success',
      title: 'Success!',
      text: text,
      timer: 3000
    }

    this.$swal(_.merge({}, defaultOptions, options))
      .then(() => {
        // resolve()
      })
      .catch(() => {
        // reject()
      })
  }
}

export default Alert
