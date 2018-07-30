<template>
    <div>
        <div v-if="!rooms.length">
            <div class="ph-item">
                <div class="ph-row">
                    <div class="ph-col-8 big"></div>
                    <div class="ph-col-4 empty big"></div>
                </div>
            </div>
        </div>
        <div v-if="rooms.length" class="users-list">
            <div v-for="room in rooms" 
                :key="room.id">
                <div class="p-2 mb-1 bg-secondary text-white text-truncate" @click="directTo(room.id)">
                    {{room.name}}
                </div>
            </div>
        </div>
    </div> 
</template>

<script>


export default {
  name: "room-list",
  props: {
    rooms: Array,
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
