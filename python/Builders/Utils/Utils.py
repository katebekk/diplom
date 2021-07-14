import cv2
from matplotlib import pyplot as plt


class Utils(object):


    @staticmethod
    def read_image_as_array(image_path):
        img = cv2.imread(image_path)
        return img

    @staticmethod
    def show_image(img):
        plt.imshow(img)
        plt.show()

    @staticmethod
    def show_two_image_together(img1, img2, title=None):
        fig = plt.figure(title)
        plt.suptitle(title)
        # show first image
        ax = fig.add_subplot(1, 2, 1)
        plt.imshow(img1, cmap=plt.cm.gray)
        plt.axis("off")
        # show the second image
        ax = fig.add_subplot(1, 2, 2)
        plt.imshow(img2, cmap=plt.cm.gray)
        plt.axis("off")
        # show the images
        plt.show()


