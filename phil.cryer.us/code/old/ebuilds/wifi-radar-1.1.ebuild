# Copyright 1999-2004 Gentoo Foundation
# Distributed under the terms of the GNU General Public License v2
# $Header: /var/cvsroot/gentoo-x86/

inherit eutils

DESCRIPTION="WiFi Radar is a Python/PyGTK2 utility for managing WiFi profiles."
HOMEPAGE="http://www.bitbuilder.com/wifi_radar/"
SRC_URI="http://www.bitbuilder.com/wifi_radar/bins/${P}.tar.gz"  
LICENSE="GPL-2"

SLOT="0"
KEYWORDS="~x86"
IUSE=""

DEPEND=">=dev-lang/python=2.3.3
		>=dev-python/pygtk-2.4.1
		>=net-wireless/wireless-tools-27"

src_unpack() {
	# fix compilation errors (bad empty constructors)
	unpack ${A}
	cd ${WORKDIR}
}
