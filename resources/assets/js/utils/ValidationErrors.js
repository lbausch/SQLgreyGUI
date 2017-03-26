export default class ValidationErrors {
    constructor(errors) {
        this.ValidationErrors = {};

        if (errors) {
            this.set(errors)
        }
    }

    has(field) {
        return this.ValidationErrors.hasOwnProperty(field)
    }

    first(field) {
        if (!this.has(field)) {
            return null
        }

        return this.ValidationErrors[field][0]
    }

    add(field, messages) {
        if (!(field in this.ValidationErrors)) {
            this.ValidationErrors[field] = []
        }

        this.ValidationErrors[field] = _.concat(this.ValidationErrors[field], messages)
    }

    set(errors) {
        this.clear()

        for (let field in errors) {
            this.add(field, errors[field])
        }

        // Trigger reactivity
        this.ValidationErrors = _.clone(this.ValidationErrors);
    }

    clear() {
        this.ValidationErrors = {}
    }
}
