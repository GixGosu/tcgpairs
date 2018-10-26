<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Team Create</div>
                    <div class="card-body">
                      <form @submit.prevent="handleSubmit">
                        <table class="table">
                          <tr><td>
                            <label>
                              Tournament ID (will autofill soon):
                              <input type="text" v-model="team.tournamentId"/>
                            </label>
                          </td></tr>
                          <tr><td>
                            <label>
                              Team Name:
                              <input type="text" v-model="team.teamName"/>
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
    </div>
</template>

<script>
import Team from '../../resources/team.js'

export default {
  data: function () {
    return {
      team: {
        teamName: 'Timmys Longshots',
        tournamentId: 1
      }
    }
  },
  mounted: function () {
  },
  methods: {
    handleSubmit: function() {
      Team.create(this.team).then((response) => {
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
