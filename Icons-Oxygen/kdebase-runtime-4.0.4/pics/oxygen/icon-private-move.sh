#!/bin/sh

if [ $# -ne 2 ]; then
  echo "You need to supply two arguments, e.g.:"
  echo "$0 actions/view-file-columns ../../../../kdebase/apps/dolphin/icons/ "
  exit
fi

# Split the two arguments into their category and icon name parts.
src="$1"
src_category=${src%/*}
src_icon=${src#*/}

dest="$2"

svn add $dest

# Move the scalable icon.
if [ -f scalable/$src.svgz ]; then
  echo "Moving scalable/$src.svgz to $dest/oxsc-$src_category-$src_icon.svgz..."
  svn mv scalable/$src.svgz $dest/oxsc-$src_category-$src_icon.svgz
  echo
fi

# Move the optimized small versions of the icon.
for size in 8 16 22 32 48 64 128; do
  dir="${size}x${size}"

  if [ -f scalable/$src_category/small/$dir/$src_icon.svgz ]; then
    echo "Moving scalable/$src_category/small/$dir/$src_icon.svgz"
    echo "    to $dest/ox$size-$src_category-$src_icon.svgz..."

    # Generate the size dir for smaller SVGs (e.g. icons/22x22/) if necessary.
    if [ ! -d $dest/small ]; then
      svn mkdir $dest/small
    fi

    svn mv scalable/$src_category/small/$dir/$src_icon.svgz $dest/small/ox$size-$src_category-$src_icon.svgz
    echo
  fi
done

# Move the rendered PNGs.
for size in 8 16 22 32 48 64 128; do
  dir="${size}x${size}"

  if [ -f $dir/$src.png ]; then
    echo "Moving $dir/$src.png to $dest/ox$size-$src_category-$src_icon.png..."
    svn mv $dir/$src.png $dest/ox$size-$src_category-$src_icon.png
    echo
  fi
done
