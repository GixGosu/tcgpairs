<template>
    <div class="tournament-wrapper">
        <table-controls
          :date-picker="false"
          :index-request="indexRequest"
          :resource-info="pagination"
          :get-records="getInventory"></table-controls>
        <table class="cp-table-standard">
            <thead>
                    <th>Image</th>
                    <th @click="sortColumn('name')">Product
                        <span v-show="indexRequest.column == 'name'">
                            <span v-show="reverseSort"><i class='lnr lnr-sort-alpha-asc'></i></span>
                            <span v-show="!reverseSort"><i class='lnr lnr-sort-alpha-desc'></i></span>
                        </span>
                    </th>
                    <th @click="sortColumn('size')">Size
                        <span v-show="indexRequest.column == 'size'">
                            <span v-show="reverseSort"><i class='lnr lnr-sort-alpha-asc'></i></span>
                            <span v-show="!reverseSort"><i class='lnr lnr-sort-alpha-desc'></i></span>
                        </span>
                    </th>
                    <th @click="sortColumn('quantity_available')">Quantity Available
                        <span v-show="indexRequest.column == 'quantity_available'">
                            <span v-show="reverseSort"><i class='lnr lnr-sort-numeric-asc'></i></span>
                            <span v-show="!reverseSort"><i class='lnr lnr-sort-numeric-desc'></i></span>
                        </span>
                    </th>
                    <th @click="sortColumn('premium_price')">Premium Price
                        <span v-show="indexRequest.column == 'premium_price'">
                            <span v-show="reverseSort"><i class='lnr lnr-sort-numeric-asc'></i></span>
                            <span v-show="!reverseSort"><i class='lnr lnr-sort-numeric-desc'></i></span>
                        </span>
                    </th>
                    <th @click="sortColumn('wholesale_price')">Wholesale Price
                        <span v-show="indexRequest.column == 'wholesale_price'">
                            <span v-show="reverseSort"><i class='lnr lnr-sort-numeric-asc'></i></span>
                            <span v-show="!reverseSort"><i class='lnr lnr-sort-numeric-desc'></i></span>
                        </span>
                    </th>
                    <th @click="sortColumn('msrp')">Suggested Retail Price
                        <span v-show="indexRequest.column == 'msrp'">
                            <span v-show="reverseSort"><i class='lnr lnr-sort-numeric-asc'></i></span>
                            <span v-show="!reverseSort"><i class='lnr lnr-sort-numeric-desc'></i></span>
                        </span>
                    </th>
                    <th @click="sortColumn('manufacturer_sku')">Manufacturer SKU
                        <span v-show="indexRequest.column == 'manufacturer_sku'">
                            <span v-show="reverseSort"><i class='lnr lnr-sort-numeric-asc'></i></span>
                            <span v-show="!reverseSort"><i class='lnr lnr-sort-numeric-desc'></i></span>
                        </span>
                    </th>
                    <th @click="sortColumn('custom_sku')">Custom SKU
                        <span v-show="indexRequest.column == 'custom_sku'">
                            <span v-show="reverseSort"><i class='lnr lnr-sort-numeric-asc'></i></span>
                            <span v-show="!reverseSort"><i class='lnr lnr-sort-numeric-desc'></i></span>
                        </span>
                    </th>
                    <th @click="sortColumn('items.created_at')">Created Date
                        <span v-show="indexRequest.column == 'items.created_at'">
                            <span v-show="reverseSort"><i class='lnr lnr-sort-numeric-asc'></i></span>
                            <span v-show="!reverseSort"><i class='lnr lnr-sort-numeric-desc'></i></span>
                        </span>
                    </th>
                    <th @click="sortColumn('inventories.expires_at')">Expiration Date
                        <span v-show="indexRequest.column == 'inventories.expires_at'">
                            <span v-show="reverseSort"><i class='lnr lnr-sort-numeric-asc'></i></span>
                            <span v-show="!reverseSort"><i class='lnr lnr-sort-numeric-desc'></i></span>
                        </span>
                    </th>
                    <th v-if="Auth.check(['Superadmin'])">
                        <!-- Save Button -->
                    </th>
                </thead>
                <tbody>
                    <tr v-for="(inventory, index) in inventories">
                    <td v-if="inventory.default_media"><img v-bind:src="inventory.default_media.url_xxs" alt="" class="inventory-image"></td>
                    <td v-else></td>
                    <td><a v-bind:href="'/products/' + inventory.product_id + '/edit/'">{{inventory.name}}</a></td>
                    <td>{{ inventory.size }}</td>
                    <td><input type="number" @keyup="saveQuantity(inventory, inventory.quantity_available)" v-model="inventory.quantity_available"></input></td>
                    <td><span>{{ inventory.premium_price | currency }}</span></td>
                    <td><span>{{ inventory.wholesale_price | currency }}</span></td>
                    <td><span>{{ inventory.msrp | currency }}</span></td>
                    <td>{{ inventory.manufacturer_sku }}</td>
                    <td>{{ inventory.custom_sku }}</td>
                    <td>{{ inventory.created_at | cpStandardDate }}</td>
                    <td v-if="Auth.check(['Superadmin'])" ><input type="date" v-model="inventory.expires_at"></td>
                    <td v-if="Auth.check(['Superadmin'])"><button class="cp-button-standard" @click="confirmation(inventory.id, inventory.expires_at)">Save Expiration</button></td>
                    <td v-if="Auth.check(['Admin']) && inventory.expires_at != null" >{{ inventory.expires_at | cpStandardDate }}</td>
                    <td v-if="Auth.check(['Admin']) && inventory.expires_at == null" ></td>
                    </tr>
                </tbody>
            </table>
            <div class="align-center">
                <img class="loading" :src="$getGlobal('loading_icon').value" v-if="loading">
                <vue-paginator
                :pagination="pagination"
                :callback="getInventory"
                :offset="2"></vue-paginator>
            </div>
    </div>
</template>
<script>
export default {
  data: function () {
    return {
        media: {},
        errorMessages: {},
        uploading: false,
        uploadZone: {},
        Auth: Auth,
        inventory: [],
        showDropzone: false,
        loading: false,
        inventories: [],
        pagination: {},
        asc: false,
        instructionsModal: false,
        importModal: false,
        importSteps: true,
        importSuccess: false,
        importRequest: {
            id: "",
            name: ""
        },
        indexRequest: {
            order: 'DESC',
            column: 'items.created_at',
            per_page: 15,
            search_term: '',
            page: 1
        },
        quantity: [],
        reverseSort: false,
        showConfirm: false,
        selectedInventory: null,
        selectedExpiration: null,
        selectedRep: {},
        reps: [],
        searchTerm: " "
    }
  },
  mounted: function () {
    this.getInventory()
  },
  methods: {
  },
  components: {
    VuePaginator: require('../../common/tables/vue-pagination.js'),
    TableControls: require('../../common/tables/TableControls.vue')
  }
}
</script>
