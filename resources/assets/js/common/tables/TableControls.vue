<template lang="html">
  <div class="cp-table-controls">
    <div class="col">
      <div class="table-date-picker">
        <span v-if="datePicker">
          <i class="lnr lnr-calendar-full icon"></i> <input type="date" data-date-inline-picker="false" data-date-open-on-focus="true" v-model="dateRange.start_date" @change="getRecordsWithDelay()">
          <i class="lnr lnr-calendar-full icon"></i> <input type="date" data-date-inline-picker="false" data-date-open-on-focus="true" v-model="dateRange.end_date" @change="getRecordsWithDelay()">
        </span>
        <span class="total-records" v-if="resourceInfo">
          <label>Total Records: </label> {{ resourceInfo.total }}
        </span>
      </div>
    </div>
    <div class="col right">
      <cp-select
      class="limit-select right"
      label="Records per page"
      :hide-label="true"
      :options="[
      { name: '15', value: 15 },
      { name: '25', value: 25 },
      { name: '50', value: 50 },
      { name: '100', value: 100 }
      ]"
      :value.sync="indexRequest.per_page"></cp-select>
      <div v-if="searchBox === true">
        <cp-search-box
          class="right"
          :placeholder="searchPlaceHolder"
          :search-term.sync="indexRequest.search_term"></cp-search-box>
      </div>
    </div>
    </div>
  </div>
</template>

<script>
import _ from 'lodash'

export default {
  data () {
    return {
      perPageDefaultSet: false
    }
  },
  props: {
    datePicker: {
      type: Boolean,
      required: false,
      default () {
        return false
      }
    },
    indexRequest: {
      twoWay: true,
      required: true,
      type: Object
    },
    dateRange: {
      twoWay: true,
      type: Object
    },
    resourceInfo: {
      type: Object,
      twoWay: true,
      required: false,
      default () {
        return null
      }
    },
    getRecords: {
      type: Function,
      required: false,
      default () {
        // do nothing
      }
    },
    searchPlaceHolder: {
      type: String,
      default () {
        return 'Search'
      }
    },
    searchBox: {
      type: Boolean,
      required: false,
      default: true
    }
  },
  ready () {
    this.setDefaultPerPage()
  },
  methods: {
    setDefaultPerPage () {
      this.perPageDefaultSet = true
      this.getRecords()
    },
    getRecordsWithDelay: _.debounce(function () {
      this.indexRequest.current_page = 1
      this.resourceInfo.current_page = 1
      this.getRecords()
    }, 700)
  },
  watch: {
    'indexRequest.search_term': _.debounce(function () {
      this.indexRequest.current_page = 1
      this.resourceInfo.current_page = 1
      this.getRecords()
    }, 400),
    'indexRequest.per_page': function () {
      if (!this.perPageDefaultSet) {
        this.indexRequest.current_page = 1
        this.resourceInfo.current_page = 1
        this.getRecords()
      }
    }
  },
  components: {
    CpSearchBox: require('../inputs/SearchBox.vue'),
    CpSelect: require('../inputs/Select.vue')
  }
}
</script>

<style lang="scss">
.cp-table-controls {
  display: flex;
  .col {
    flex: 1;
  }
  .right {
    float: right;
  }
  .total-records {
    label {
      padding-top: 5px;
    }
  }
  .limit-select {
    margin-right: 5px;
    select {
      width: 60px;
      min-width: 60px;
    }
  }
}

  @media (max-width: 476px) {
  .cp-table-controls{
    display: block;
    margin-bottom: 80px;
    }
  }
@media (max-width: 768px) {
    .cp-table-controls{
      display: block;
      .right{
        float: none;
      }
      .cp-search-box{
            padding: 0px 10px;
          & > input {
        width: 90% !important;
      }
    }

  }
}
</style>
