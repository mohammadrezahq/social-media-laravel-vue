<template>
  <div class="flex flex-col my-2 space-y-1">
    <label>{{label}}:</label>
      <input
        class="p-2 border-gray-200 border rounded-md outline-none focus:border-blue-600"
        :type="type"
        :value="modelValue"
        @keydown.space="preventSpace"
        @input='$emit("update:modelValue", $event.target.value)'
      />
      <div v-for="(error, i) in errors" :key="i">
        <p class="text-red-600">{{error}}</p>
      </div>
  </div>
</template>

<script>
export default {
  name: 'Input',
  props: {
    modelValue: String,
    errors: Array,
    type: String,
    label: String,
    space: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    preventSpace (event) {
      if (this.space) {
        event.preventDefault()
      }
    }
  }
}
</script>
