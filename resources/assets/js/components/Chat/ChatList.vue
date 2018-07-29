<template>
    <div>
        <div v-if="!users.length">
            <div class="ph-item">
                <div class="ph-col-1">
                    <div class="ph-avatar"></div>
                </div>
                <div class="ph-row">
                    <div class="ph-col-8 big"></div>
                    <div class="ph-col-4 empty big"></div>
                </div>
            </div>
        </div>
        <div v-if="users" class="users-list">
            <div v-for="user in users" 
                :key="user.id">
                <div v-if="user.id == me" class="p-2 mb-1 bg-primary text-white">
                    {{user.name}}
                </div>
                <div v-else class="p-2 mb-1 bg-secondary text-white" @click="directTo(user.id)">
                    {{user.name}}
                </div>
            </div>
        </div>
    </div> 
</template>

<script>


export default {
  name: "chat-list",
  props: {
    users: Array,
    channel: String,
    me: 0
  },
  mounted() {
  },
  methods: {
      directTo(id) {
          this.$snotify.simple("selected direct "+id);
          this.$emit('directmsg', id)
      }
  }
};
</script>
