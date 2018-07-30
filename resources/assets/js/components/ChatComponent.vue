<template>
    <div class="d-flex flex-column" id="chat-component">
      <div class="card text-white bg-dark" id="main-chat-card">
          <div class="card-header">Yepy Machat</div>
          <div class="card-body d-flex flex-row align-items-stretch">
            <div class="d-none d-sm-none d-md-block col-md-2">
              tuka ke se kanali a u   
            </div>
            <div class="col-xs-12 col-md-8 d-flex flex-column align-items-stretch bd-highlight mb-3">
              <message-list :messages="messages" @onScrollTop="loadMore" :user="user.id"></message-list>      

              <div class="p-2">
                <input type="text" autofocus name="michat" class="form-control" id="michat" v-model="message" @keyup.enter="addMessage">         
              </div>
            </div>
            <div class="d-none d-sm-none d-md-block col-md-2">
              <chat-list :users="users" :me="user.id" @directmsg="directmsg"></chat-list>    
            </div>
          </div>
        </div>
    </div>
</template>

<script>
Vue.component("chat-list", require("./Chat/ChatList.vue"));
Vue.component("message-list", require("./Chat/MessageList.vue"));
import VueChatScroll from "vue-chat-scroll";

Vue.use(VueChatScroll);

export default {
  data: function() {
    return {
      users: [],
      messages: [],
      message: "",
      direct: 0,
      channel: "default",
      nextpage: "",
      loading: false
    };
  },
  props: {
    user: Object
  },
  mounted() {
    // join the main channel
    this.joinChannel(this.channel);

    //  listen for direct messages
    Echo.private(`user.${this.user.id}`).listen("SendMessage", e => {
      this.messages.push(e.message);
      this.$snotify.simple("You got Direct message");
    });

    // handle ghost typing event
    Echo.private("chat").listenForWhisper("typing", e => {
      this.$snotify.simple(e.name + "is typing... ");
      // console.log(e.name + "Typing... ");
    });

    // register notifications pool
    Echo.private(`App.User.${this.user.id}`).notification(notification => {
      this.$snotify.success(notification.message);
      // console.log(notification);
    });

    this.$snotify.simple("Macychat loaded");
  },
  methods: {
    /**
     * Join channel
     */
    joinChannel(channel) {
      this.channel = channel;
      Echo.join(`chat.${channel}`)
        .here(users => {
          this.users = users;
        })
        .joining(user => {
          this.users.push({ id: user.id, name: user.name });
          this.$snotify.simple(user.name + " joined the party");
        })
        .leaving(user => {
          this.users = _.remove(this.users, function(n) {
            return n.id != user.id;
          });
          this.$snotify.simple(user.name + " left the party");
        })
        .listen("SendMessage", e => {
          //
          this.messages.push(e.message);
        });

      //  Load channel history
      axios
        .get(`/message/${channel}`)
        .then(response => {
          // console.log(response);
          this.messages = _.reverse(response.data.data);
          this.nextpage = response.data.next_page_url;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
          console.log(this);
        });
    },
    loadMore() {
      if (this.loading) return;
      this.loading=true;
      if (this.nextpage) {
        console.log('LOADING MORE>>>')
        axios
          .get(this.nextpage)
          .then(response => {
            this.messages = _.union(_.reverse(response.data.data), this.messages);
            this.nextpage = response.data.next_page_url;
            this.loading = false;
          })
          .catch(function(error) {
            // handle error
            console.log(error);
            console.log(this);
            this.loading = false;
          });
      }
    },
    addMessage() {
      //   this.messages.push(message);
      if (!this.message) return;
      let data = {
        message: this.message,
        from_id: this.user.id,
        from_name: this.user.name,
        room_id: this.channel,
        is_public: true
      };
      if (this.direct) {
        data.room_id = this.direct;
        data.is_public = false;
      }
      axios
        .post("/message", data)
        .then(response => {
          // console.log(response);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
          console.log(this);
        });
      this.message = "";
    },
    ghostTyping() {
      Echo.private("chat").whisper("typing", {
        name: this.user.name
      });
    },
    directmsg(id) {
      this.direct = id;
    }
  }
};
</script>
