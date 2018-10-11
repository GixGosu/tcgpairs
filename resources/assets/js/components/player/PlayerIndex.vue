<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">player Index</span></div>

                    <div class="card-body">
                        <table>
                          <thead>
                            <th @click="sortColumn('player.id')">ID
                                <span v-show="indexRequest.column == 'player.id'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('player.f_name')">First Name
                                <span v-show="indexRequest.column == 'player.f_name'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('player.l_name')">Last Name
                                <span v-show="indexRequest.column == 'player.l_name'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('player.phone')">Phone
                                <span v-show="indexRequest.column == 'player.phone'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('player.email')">Email
                                <span v-show="indexRequest.column == 'player.email'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('player.created_at.date')">Created At
                                <span v-show="indexRequest.column == 'player.created_at.date'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('player.updated_at.date')">Updated At
                                <span v-show="indexRequest.column == 'player.updated_at.date'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                          </thead>
                          <tr v-for="player in players">
                            <td>{{ player.id }}</td>
                            <td>{{ player.f_name }}</td>
                            <td>{{ player.l_name }}</td>
                            <td>{{ player.phone }}</td>
                            <td>{{ player.email }}</td>
                            <td>{{ player.created_at.date }}</td>
                            <td>{{ player.updated_at.date }}</td>
                          </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import player from '../../resources/player.js'

export default {
  data: function () {
    return {
      players: [],
      indexRequest: {
          order: 'DESC',
          column: 'player.id',
          per_page: 10,
          search_term: '',
          page: 1
      },
      reverseSort: true
    }
  },
  mounted: function () {
    console.log('Component mounted.')
    this.loadplayers()
  },
  methods: {
    loadplayers: function() {
      player.index()
        .then((response) => {
          if (response.error) {
            console.log('error')
          }
          this.players = response.data
          console.log(response)
        })
    },
    sortColumn: function(column) {
      if (this.indexRequest.column == column) {
        this.reverseSort = !this.reverseSort
      } else {
        this.indexRequest.column = column
      }
    }
  }
}
</script>
