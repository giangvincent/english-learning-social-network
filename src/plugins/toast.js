import { useToast } from 'vue-toast-notification';

let toastInstance = null;

export const installToast = (app, options = {}) => {
  toastInstance = useToast({
    position: 'top-right',
    ...options,
  });
  app.config.globalProperties.$toast = toastInstance;
  return toastInstance;
};

export const getToast = () => {
  if (!toastInstance) {
    toastInstance = useToast({
      position: 'top-right',
    });
  }
  return toastInstance;
};
