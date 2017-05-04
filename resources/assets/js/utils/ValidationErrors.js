export default class ValidationErrors {
  constructor (errors) {
    this.ValidationErrors = {}

    if (errors) {
      this.set(errors)
    }
  }

  has (field) {
    return this.ValidationErrors.hasOwnProperty(field)
  }

  hasGeneral () {
    for (let field in this.ValidationErrors) {
      if (this.ValidationErrors.hasOwnProperty(field) && field === '*') {
        return true
      }
    }

    return false
  }

  first (field) {
    if (!this.has(field)) {
      return null
    }

    return this.ValidationErrors[field][0]
  }

  firstGeneral () {
    if (!this.hasGeneral()) {
      return null
    }

    return this.first('*')
  }

  add (field, messages) {
    if (!(field in this.ValidationErrors)) {
      this.ValidationErrors[field] = []
    }

    this.ValidationErrors[field] = _.concat(this.ValidationErrors[field], messages)
  }

  set (errors) {
    this.clear()

    for (let field in errors) {
      if (errors.hasOwnProperty(field)) {
        this.add(field, errors[field])
      }
    }

    // Trigger reactivity
    this.ValidationErrors = _.clone(this.ValidationErrors)
  }

  clear () {
    this.ValidationErrors = {}
  }
}
