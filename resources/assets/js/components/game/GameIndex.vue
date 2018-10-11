<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Game Index</span></div>

                    <div class="card-body">
                        <table>
                          <thead>
                            <th @click="sortColumn('game.id')">ID
                                <span v-show="indexRequest.column == 'game.id'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('game.title')">Game ID
                                <span v-show="indexRequest.column == 'game.game_id'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('game.abbrv')">Format ID
                                <span v-show="indexRequest.column == 'game.format_id'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('game.created_at')">Created At
                                <span v-show="indexRequest.column == 'game.created_at'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('game.updated_at')">Updated At
                                <span v-show="indexRequest.column == 'game.updated_at'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                          </thead>
                          <tr v-for="game in games">
                            <td>{{ game.id }}</td>
                            <td>{{ game.title }}</td>
                            <td>{{ game.abbrv }}</td>
                            <td>{{ game.created_at }}</td>
                            <td>{{ game.updated_at }}</td>
                          </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import game from '../../resources/game.js'

export default {
  data: function () {
    return {
      games: [],
      indexRequest: {
          order: 'DESC',
          column: 'game.id',
          per_page: 10,
          search_term: '',
          page: 1
      },
      reverseSort: true
    }
  },
  mounted: function () {
    console.log('Component mounted.')
    this.loadgames()
  },
  methods: {
    loadgames: function() {
      game.index()
        .then((response) => {
          if (response.error) {
            console.log('error')
          }
          this.games = response.data
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
