<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Tournament Create</div>

                    <div class="card-body">
                      <form @submit.prevent="handleSubmit">
                        <table class="table">
                          <tr><td>
                            <label>
                              Title:
                              <input type="text" v-model="tournament.title"/>
                            </label>
                          </td></tr>
                          <tr><td>
                            <label>
                              Game ID:
                              <input type="text" v-model="tournament.gameId"/>
                            </label>
                          </td></tr>
                          <tr><td>
                            <label>
                              Format ID:
                              <input type="text" v-model="tournament.formatId"/>
                            </label>
                          </td></tr>
                          <tr><td>
                            <label>
                              Location ID:
                              <input type="text" v-model="tournament.locationId"/>
                            </label>
                          </td></tr>
                          <tr><td>
                            <label>
                              Event Date and Time:
                              <datetime v-model="tournament.eventTime" type="datetime"></datetime>
                            </label>
                          </td></tr>
                          <tr><td>
                            <button type="submit">Submit</button>
                          </td></tr>
                        </table>
                      </form>
                    </div>
                </div>
            </div>
        </div>
        <team-create></team-create>
    </div>
</template>

<script>
import Tournament from '../../resources/tournament.js'

export default {
  data: function () {
    return {
      tournament: {
        title: 'Timmys Tournament',
        gameId: '1',
        formatId: '1',
        locationId: '1',
        eventTime: '2018-06-12T19:30'
      },
      showTournamentLink: false,
      tournamentLink: ''
    }
  },
  mounted: function () {
  },
  methods: {
    handleSubmit: function() {
      Tournament.create(this.tournament).then((response) => {
        if (response.error) {
          console.log('error')
        }
        this.tournamentLink = response.data
        console.log(response)
      })
    }
  }
}
</script>
