<template>
    <div class="mb-auto p-2 messages-list">
        <div v-if="!messages.length">
            <div class="ph-item">
                <div class="ph-col-12">
                    <div class="ph-picture"></div>
                    <div class="ph-row">
                        <div class="ph-col-8 big"></div>
                        <div class="ph-col-4 empty big"></div>
                        <div class="ph-col-6 big"></div>
                        <div class="ph-col-4 empty big"></div>
                        <div class="ph-col-2 big"></div>
                        <div class="ph-col-4"></div>
                        <div class="ph-col-8 empty"></div>
                        <div class="ph-col-6"></div>
                        <div class="ph-col-6 empty"></div>
                        <div class="ph-col-12"></div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="messages" v-chat-scroll>
            <div v-for="message in messages" 
            :key="message.id"
            >
                <div v-if="!samePerson(message)">
                    <hr>
                    <h5 class="p-2 mb-3 bg-dark text-white shadow rounded">{{message.from_name}} <small>{{message.created_at+" +0000" | moment("from") }}</small> </h5>
                </div>

                <p>{{message.message}}</p>
            </div>
        </div>
    </div> 
</template>

<script>
export default {
  name: "message-list",
  data: function() {
    return {
      lastFrom: 0,
      lastUpdate: 0
    };
  },
  props: {
    messages: Array,
    channel: String,
    user: 0
  },
  mounted() {
    console.log("Users list.");
  },
  methods: {
      samePerson(message) {
          if (this.lastFrom != message.from_id || moment(message.created_at).from() != this.lastUpdate ) {
              this.lastFrom = message.from_id;
              this.lastUpdate = moment(message.created_at).from();
              return false;
          }
          
          return true;
      }
  }
};
</script>
