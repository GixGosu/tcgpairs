<template lang="html">
  <span class="select-standard-wrapper">
    <label v-if="!hideLabel">{{ label }}</label>
      <div class="cp-select-standard">
        <select
          :class="{ 'select-error': error, 'error': error }"
          ref="input"
          v-model="value">
          <option v-for="option in options" :value="option[keyValue['value']] || option">{{ option[keyValue['name']] || option.name }}</option>
        </select>
      </div>
      <span :class="{ 'cp-validation-errors': error }" v-if="error">{{ error[0] }}</span>
  </span>
</template>

<script>
export default {
  props: {
    value: {
      twoWay: true
    },
    options: {
      type: Array
    },
    keyValue: {
      type: Object,
      default () {
        return {
          name: 'name',
          value: 'value'
        }
      }
    },
    hideLabel: {
      type: Boolean,
      default () {
        return false
      }
    },
    placeholder: {},
    error: {},
    label: {}
  }
}
</script>

<style lang="scss" scoped>
.select-standard-wrapper {
  label {
    display: inline-block;
  }
}
.select-error {
  border: 1px solid tomato !important;
}

@media (max-width: 768px) {
    .cp-table-controls .limit-select select {
        min-width: 96px;
    }
}
</style>
