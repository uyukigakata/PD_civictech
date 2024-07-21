import matplotlib.pyplot as plt
import japanize_matplotlib
import os

# 総数データ取得
with open(r"C:\xampp\htdocs\test\TXT\kaga_count.txt", 'r') as file:
    lines = file.readlines()

kaga = int(lines[0].strip())
kaga_w1 = int(lines[1].strip())
kaga_w2 = int(lines[2].strip())
kaga_w3 = int(lines[3].strip())
kaga_other = int(lines[4].strip())

labels = ['ゴミ', '人', '環境', 'その他']
sizes = [kaga_w1, kaga_w2, kaga_w3, kaga_other]

plt.figure(figsize=(5, 5))
plt.pie(sizes, labels=labels, autopct='%1.1f%%')
plt.legend(labels, loc="upper right")
plt.title('加賀市')
plt.tight_layout()
save_dir = "../png"
if not os.path.exists(save_dir):
    os.makedirs(save_dir)
plt.savefig('../png/kaga_graph.png', bbox_inches='tight', pad_inches=0.2)