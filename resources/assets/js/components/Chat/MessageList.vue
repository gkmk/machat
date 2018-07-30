<template>
    <div class="d-flex flex-column align-items-stretch mb-auto p-2">
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
        <div v-show="messages.length" id="messages-list" v-chat-scroll>
            <div v-for="message in messages" 
            :key="message.id"
            >
                <div v-if="!samePerson(message)">
                    <hr>
                    <h5 class="p-2 mb-3 mr-3 bg-dark text-white shadow rounded">{{message.from_name}} <small><small>{{message.created_at | moment("calendar") }}</small></small> </h5>
                </div>

                <p>{{message.message}}</p>
            </div>
        </div>
    </div> 
</template>

<script>
var messageHistory = {
  lastFrom: 0,
  lastUpdate: 0
};
export default {
  name: "message-list",
  data: function() {
    return {};
  },
  props: {
    messages: Array,
    channel: String,
    user: 0
  },
  mounted() {
    console.log("Users list.");
    this.scroll(this);
  },
  methods: {
    samePerson(message) {
      if (
        messageHistory.lastFrom != message.from_id ||
        moment(message.created_at).calendar() != messageHistory.lastUpdate
      ) {
        messageHistory.lastFrom = message.from_id;
        messageHistory.lastUpdate = moment(message.created_at).calendar();
        return false;
      }
      return true;
    },
    scroll(v) {
      $("#messages-list").scroll(function() {
        let top = $(this).scrollTop();
        if (top <= 20) {
          v.$emit("onScrollTop");
        }
      });
    }
  }
};
</script>
