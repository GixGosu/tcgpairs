<template lang="html">
    <div class="cp-search-box">
        <input type="text"
        class="form-control ng-pristine ng-valid"
        name="new_tag"
        :placeholder="placeholder"
        v-model="search_term"
        @keyup="setSearchTerm()">
        <button class="search-button" type="button" @click="setSearchTerm()">
            <i class="lnr lnr-magnifier"></i>
        </button>
    </div>
</template>
<script>
import _ from 'lodash'

export default {
  data: function () {
    return {
      search_term: ''
    }
  },
  props: {
    placeholder: {
      type: String,
      default () {
        return 'Search'
      }
    },
    searchTerm: {
      type: String,
      twoWay: true
    }
  },
  methods: {
    setSearchTerm: _.debounce(function () {
      this.searchTerm = this.search_term
    }, 500)
  }
}
</script>
<style lang="scss">
    @import "resources/assets/sass/var.scss";

    .cp-search-box {
        // float: right;
        width: auto;
        top: 8px;
        right: 5px;
        margin-bottom: 10px;
        input {
            // float: left;
            width: 200px;
            display: inline;
            border: none;
            padding: 0px 0px 0px 10px;
            border-bottom: solid 1px $cp-lightGrey;
            border-radius: 0 !important;
            box-shadow: none;
            -webkit-box-shadow: none;
            font-size: 16px;
        }
        input:focus {
            box-shadow: none;
            -webkit-box-shadow: none;
            border-bottom: solid 1px $cp-main;
        }
        ::-webkit-input-placeholder {
           color: $cp-lightGrey;
           text-align: right;
        }

        :-moz-placeholder {
            color: $cp-lightGrey;
           text-align: right;
        }

        ::-moz-placeholder {
            color: $cp-lightGrey;
           text-align: right;
        }

        :-ms-input-placeholder {
            color: $cp-lightGrey;
           text-align: right;
        }
        .search-button {
                // float: left;
                background: transparent !important;
                box-shadow: none;
                font-size: 18px;
                width: 34px;
                padding: 4.5px;
                border: none !important;
                &.sm-case {
                    font-size: 14px;
                    margin-top: 0;
                }
        }

    }
</style>
