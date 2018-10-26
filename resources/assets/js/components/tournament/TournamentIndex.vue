<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Tournament Index</span></div>

                    <div class="card-body">
                        <table class="table table-striped table-bordered table-hover">
                          <thead>
                            <th @click="sortColumn('tournament.id')">ID
                                <span v-show="indexRequest.column == 'tournament.id'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('tournament.game_id')">Game ID
                                <span v-show="indexRequest.column == 'tournament.game_id'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('tournament.format_id')">Format ID
                                <span v-show="indexRequest.column == 'tournament.format_id'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('tournament.title')">Tournament Title
                                <span v-show="indexRequest.column == 'tournament.title'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('tournament.event_time')">Event Time
                                <span v-show="indexRequest.column == 'tournament.event_time'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('tournament.done')">Completed
                                <span v-show="indexRequest.column == 'tournament.done'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('tournament.created_at.date')">Created At
                                <span v-show="indexRequest.column == 'tournament.created_at.date'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th @click="sortColumn('tournament.updated_at.date')">Updated At
                                <span v-show="indexRequest.column == 'tournament.updated_at.date'">
                                    <span v-show="reverseSort"><i class='glyphicon glyphicon-arrow-up'></i></span>
                                    <span v-show="!reverseSort"><i class='glyphicon glyphicon-arrow-down'></i></span>
                                </span>
                            </th>
                            <th>
                                <a href="/tournament/create"><span class="glyphicon glyphicon-new-window"></span></a>
                            </th>
                          </thead>
                          <tr v-for="tournament in tournaments">
                            <td>{{ tournament.id }}</td>
                            <td>{{ tournament.game_id }}</td>
                            <td>{{ tournament.format_id }}</td>
                            <td>{{ tournament.title }}</td>
                            <td>{{ tournament.event_time.date }}</td>
                            <td>{{ tournament.done }}</td>
                            <td>{{ tournament.created_at.date }}</td>
                            <td>{{ tournament.updated_at.date }}</td>
                          </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Tournament from '../../resources/tournament.js'

export default {
  data: function () {
    return {
      tournaments: [],
      indexRequest: {
          order: 'DESC',
          column: 'tournament.id',
          per_page: 10,
          search_term: '',
          page: 1
      },
      reverseSort: true
    }
  },
  mounted: function () {
    console.log('Component mounted.')
    this.loadTournaments()
  },
  methods: {
    loadTournaments: function() {
      Tournament.index()
        .then((response) => {
          if (response.error) {
            console.log('error')
          }
          this.tournaments = response.data
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
