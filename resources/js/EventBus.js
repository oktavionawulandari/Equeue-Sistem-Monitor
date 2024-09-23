// EventBus.js
import { reactive, watch } from 'vue';

const EventBus = reactive({});

export const useEventBus = () => ({
  emit(event, data) {
    EventBus[event] = data;
  },
  on(event, callback) {
    watch(
      () => EventBus[event],
      (newValue) => {
        if (newValue) {
          callback(newValue);
        }
      }
    );
  },
});
