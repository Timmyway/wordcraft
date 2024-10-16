import { ref, onUnmounted } from 'vue';

interface LongPressOptions<T = any> {
  duration?: number; // Duration for detecting long press in ms (default: 500ms)
  onLongPress: (event: TouchEvent, payload: T) => void; // Callback for long press action with a payload
  onTouchStart?: (event: TouchEvent) => void; // Optional callback for touch start
  onTouchEnd?: (event: TouchEvent) => void; // Optional callback for touch end
  onTouchMove?: (event: TouchEvent) => void; // Optional callback for touch move
}

export function useLongPress<T = any>({
  duration = 500,
  onLongPress,
  onTouchStart,
  onTouchEnd,
  onTouchMove,
}: LongPressOptions<T>) {
  const longPressTimeout = ref<number | null>(null);  // To store the timeout ID
  const isLongPressTriggered = ref(false);           // To track if long press was triggered

  const handleTouchStart = (event: TouchEvent, payload: T) => {
    if (onTouchStart) {
      onTouchStart(event);  // Invoke custom touch start handler if provided
    }

    // Set a timeout to detect a long press after the specified duration
    longPressTimeout.value = window.setTimeout(() => {
      isLongPressTriggered.value = true;
      onLongPress(event, payload);  // Trigger the long press callback with the payload
    }, duration);
  };

  const handleTouchEnd = (event: TouchEvent) => {
    if (onTouchEnd) {
      onTouchEnd(event);  // Invoke custom touch end handler if provided
    }

    // Clear the timeout if the long press wasn't triggered
    if (!isLongPressTriggered.value && longPressTimeout.value !== null) {
      clearTimeout(longPressTimeout.value);
    }

    // Reset the long press triggered flag
    isLongPressTriggered.value = false;
  };

  const handleTouchMove = (event: TouchEvent) => {
    if (onTouchMove) {
      onTouchMove(event);  // Invoke custom touch move handler if provided
    }

    // If the user moves their finger, cancel the long press detection
    if (longPressTimeout.value !== null) {
      clearTimeout(longPressTimeout.value);
    }
  };

  // Cleanup the timeout on unmount
  onUnmounted(() => {
    if (longPressTimeout.value !== null) {
      clearTimeout(longPressTimeout.value);
    }
  });

  // Return event handlers to be used in the component
  return {
    handleTouchStart,
    handleTouchEnd,
    handleTouchMove,
  };
}
