
class SectorParser():
    @staticmethod
    def img_into_sectors2(img, grid_size_div=3):
        height, width, channels = img.shape
        GRID_SIZE_H = round(height / grid_size_div)
        GRID_SIZE_W = round(width / grid_size_div)
        coordinates = []
        for x in range(0, width - 1, GRID_SIZE_W):
            for y in range(0, height - 1, GRID_SIZE_H):
                coordinates.append([x, x + GRID_SIZE_W, y, y + GRID_SIZE_H])
        return coordinates

    @staticmethod
    def img_into_sectors(img, grid_size_div=3):
        height, width, channels = img.shape
        GRID_SIZE_H = height / grid_size_div
        GRID_SIZE_W = width / grid_size_div
        coordinates = []
        for x in range(0, grid_size_div):
            for y in range(0, grid_size_div):
                coordinates.append(
                    [round(x * GRID_SIZE_W), round(x * GRID_SIZE_W + GRID_SIZE_W), round(y * GRID_SIZE_H),
                     round(y * GRID_SIZE_H + GRID_SIZE_H)])
        return coordinates

    @classmethod
    def get_img_sector(cls, img, coordinates):
        v1 = coordinates[0]
        v2 = coordinates[1]
        v3 = coordinates[2]
        v4 = coordinates[3]
        img_sector = img[v3:v4, v1:v2]
        return img_sector